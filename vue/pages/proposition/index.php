<main class="page-section">
    <div class="container">

        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="page-kicker">Groupe</span>
                <h1 class="page-title"><?= htmlspecialchars($groupe['nom']) ?></h1>
                <p class="page-description">
                    Consulte les propositions du groupe, participe aux votes et donne ton avis.
                </p>
            </div>

            <a href="routeur.php?page=propositions&action=formulaireCreation&id_groupe=<?= (int) $groupe['id_groupe'] ?>"
               class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-2"></i>
                Nouvelle proposition
            </a>
        </div>

        <?php if (!empty($budget)): ?>
            <div class="premium-card mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-cash-coin me-2 text-success"></i>
                    Budget du groupe
                </h5>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card-soft p-3">
                            <small class="text-muted">Budget total</small>
                            <div class="fw-bold">
                                <?= number_format((float) $budget['montant_total'], 2, ',', ' ') ?> €
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card-soft p-3">
                            <small class="text-muted">Budget utilisé</small>
                            <div class="fw-bold">
                                <?= number_format((float) $budget['montant_utilise'], 2, ',', ' ') ?> €
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card-soft p-3">
                            <small class="text-muted">Budget disponible</small>
                            <div class="fw-bold text-success">
                                <?= number_format((float) $budget['montant_disponible'], 2, ',', ' ') ?> €
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($propositions)): ?>

            <div class="premium-card text-center py-5">
                <div class="auth-icon mx-auto">
                    <i class="bi bi-lightbulb"></i>
                </div>

                <h4 class="fw-bold mt-3">Aucune proposition</h4>
                <p class="text-muted">
                    Sois le premier à proposer une idée pour ce groupe.
                </p>

                <a href="routeur.php?page=propositions&action=formulaireCreation&id_groupe=<?= (int) $groupe['id_groupe'] ?>"
                   class="btn btn-primary rounded-pill px-4 mt-2">
                    <i class="bi bi-plus-circle me-2"></i>
                    Créer une proposition
                </a>
            </div>

        <?php else: ?>

            <div class="row g-4">
                <?php foreach ($propositions as $proposition): ?>

                    <?php
                    $statut = $proposition['statut'] ?? 'en_attente';

                    $statutClass = match ($statut) {
                        'adoptee', 'approuvee', 'realisee' => 'text-bg-success',
                        'rejetee', 'refusee' => 'text-bg-danger',
                        'en_vote' => 'text-bg-primary',
                        default => 'text-bg-secondary',
                    };
                    ?>

                    <div class="col-md-6 col-lg-4">
                        <div class="premium-card h-100 d-flex flex-column justify-content-between">

                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge <?= $statutClass ?> rounded-pill px-3 py-2">
                                        <?= htmlspecialchars($statut) ?>
                                    </span>

                                    <span class="text-muted small">
                                        #<?= (int) $proposition['id_proposition'] ?>
                                    </span>
                                </div>

                                <h4 class="fw-bold mb-2">
                                    <?= htmlspecialchars($proposition['titre']) ?>
                                </h4>

                                <p class="text-muted small">
                                    <?= htmlspecialchars(mb_strimwidth($proposition['description'], 0, 120, '...')) ?>
                                </p>

                                <div class="mt-3">
                                    <small class="text-muted">Montant demandé</small>
                                    <div class="fw-bold text-primary">
                                        <?= number_format((float) $proposition['montant_demande'], 2, ',', ' ') ?> €
                                    </div>
                                </div>

                                <div class="mt-3 text-muted small">
                                    <i class="bi bi-person me-1"></i>
                                    <?= htmlspecialchars(($proposition['prenom'] ?? '') . ' ' . ($proposition['nom'] ?? '')) ?>
                                </div>
                            </div>

                            <div class="mt-4 d-flex justify-content-between align-items-center gap-2">
                                <a href="routeur.php?page=propositions&action=details&id_proposition=<?= (int) $proposition['id_proposition'] ?>"
                                   class="btn btn-primary rounded-pill px-3">
                                    <i class="bi bi-eye me-1"></i>
                                    Voir
                                </a>

                                <a href="routeur.php?page=propositions&action=formulaireModification&id_proposition=<?= (int) $proposition['id_proposition'] ?>"
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