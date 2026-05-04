<main class="page-section">
    <div class="container">

        <div class="page-header">
            <span class="page-kicker">Modération</span>
            <h1 class="page-title">Signalements</h1>
            <p class="page-description">
                Consulte les contenus signalés et décide s’ils doivent être traités ou rejetés.
            </p>
        </div>

        <?php if (empty($signalements)): ?>

            <div class="premium-card text-center py-5">
                <i class="bi bi-shield-check fs-1 text-success"></i>
                <h4 class="mt-3">Aucun signalement en attente</h4>
                <p class="text-muted mb-0">Tout est clean pour le moment.</p>
            </div>

        <?php else: ?>

            <div class="row g-4">
                <?php foreach ($signalements as $signalement): ?>

                    <div class="col-lg-6">
                        <div class="premium-card h-100">

                            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                <span class="badge text-bg-warning rounded-pill px-3 py-2">
                                    <i class="bi bi-flag me-1"></i>
                                    En attente
                                </span>

                                <small class="text-muted">
                                    #<?= (int) $signalement['id_signalement'] ?>
                                </small>
                            </div>

                            <h4 class="fw-bold mb-2">
                                <?= !empty($signalement['titre_proposition'])
                                    ? htmlspecialchars($signalement['titre_proposition'])
                                    : 'Commentaire signalé' ?>
                            </h4>

                            <p class="text-muted small mb-3">
                                Signalé par
                                <strong>
                                    <?= htmlspecialchars(($signalement['prenom_signaleur'] ?? '') . ' ' . ($signalement['nom_signaleur'] ?? '')) ?>
                                </strong>
                                (@<?= htmlspecialchars($signalement['login_signaleur'] ?? '') ?>)
                            </p>

                            <div class="card-soft p-3 mb-3">
                                <small class="text-muted">Motif</small>
                                <div class="fw-bold">
                                    <?= htmlspecialchars($signalement['motif']) ?>
                                </div>
                            </div>

                            <?php if (!empty($signalement['texte_commentaire'])): ?>
                                <div class="card-soft p-3 mb-3">
                                    <small class="text-muted">Commentaire concerné</small>
                                    <p class="mb-0">
                                        <?= nl2br(htmlspecialchars($signalement['texte_commentaire'])) ?>
                                    </p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($signalement['titre_proposition'])): ?>
                                <div class="card-soft p-3 mb-3">
                                    <small class="text-muted">Proposition concernée</small>
                                    <div class="fw-bold">
                                        <?= htmlspecialchars($signalement['titre_proposition']) ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <form method="post" action="routeur.php?page=signalements&action=traiter">
                                    <input type="hidden" name="id_signalement" value="<?= (int) $signalement['id_signalement'] ?>">
                                    <button class="btn btn-primary rounded-pill px-4">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Traiter
                                    </button>
                                </form>

                                <form method="post" action="routeur.php?page=signalements&action=rejeter">
                                    <input type="hidden" name="id_signalement" value="<?= (int) $signalement['id_signalement'] ?>">
                                    <button class="btn btn-light rounded-pill px-4">
                                        <i class="bi bi-x-circle me-2"></i>
                                        Rejeter
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div>
</main>