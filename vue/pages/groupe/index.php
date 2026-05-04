<main class="page-section">
    <div class="container">

        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="page-kicker">Mes espaces</span>
                <h1 class="page-title">Mes groupes</h1>
                <p class="page-description">
                    Accède à tes groupes, gère les propositions et participe aux décisions collectives.
                </p>
            </div>

            <a href="routeur.php?page=groupes&action=formulaireCreation"
               class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-2"></i>
                Nouveau groupe
            </a>
        </div>

        <?php if (empty($groupes)): ?>

            <div class="premium-card text-center py-5">
                <div class="auth-icon mx-auto">
                    <i class="bi bi-people"></i>
                </div>

                <h4 class="fw-bold mt-3">Aucun groupe pour le moment</h4>
                <p class="text-muted">
                    Crée ton premier groupe pour commencer à publier des propositions.
                </p>

                <a href="routeur.php?page=groupes&action=formulaireCreation"
                   class="btn btn-primary rounded-pill px-4 mt-2">
                    <i class="bi bi-plus-circle me-2"></i>
                    Créer un groupe
                </a>
            </div>

        <?php else: ?>

            <div class="row g-4">
                <?php foreach ($groupes as $groupe): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="premium-card group-card h-100 d-flex flex-column justify-content-between">

                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge-soft">
                                        <i class="bi bi-folder me-1"></i>
                                        Groupe
                                    </span>

                                    <span class="text-muted small">
                                        #<?= (int) $groupe['id_groupe'] ?>
                                    </span>
                                </div>

                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="group-color-dot"></span>
                                    <h4 class="fw-bold mb-0">
                                        <?= htmlspecialchars($groupe['nom']) ?>
                                    </h4>
                                </div>

                                <p class="text-muted small mb-0">
                                    <?= htmlspecialchars($groupe['description'] ?? 'Aucune description') ?>
                                </p>
                            </div>

                            <div class="mt-4 d-flex justify-content-between align-items-center gap-2">
                                <a href="routeur.php?page=propositions&id_groupe=<?= (int) $groupe['id_groupe'] ?>"
                                   class="btn btn-primary rounded-pill px-3">
                                    <i class="bi bi-eye me-1"></i>
                                    Voir
                                </a>

                                <a href="routeur.php?page=groupes&action=formulaireModification&id_groupe=<?= (int) $groupe['id_groupe'] ?>"
                                   class="btn btn-light rounded-pill px-3">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div>
</main>