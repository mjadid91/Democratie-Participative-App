<main class="page-section">
    <div class="container">

        <div class="page-header">
            <span class="page-kicker">Modification</span>
            <h1 class="page-title">Modifier le groupe</h1>
            <p class="page-description">
                Mets à jour les informations du groupe. Le budget reste visible pour garder une vision claire.
            </p>
        </div>

        <div class="auth-card" style="max-width: 760px;">

            <form method="post" action="routeur.php?page=groupes&action=modifier">

                <input type="hidden" name="id_groupe" value="<?= (int) $groupe['id_groupe'] ?>">

                <div class="mb-3">
                    <label for="nom" class="form-label fw-bold">Nom du groupe</label>
                    <input
                        type="text"
                        name="nom"
                        id="nom"
                        class="form-control"
                        value="<?= htmlspecialchars($groupe['nom'] ?? '') ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="4"
                    ><?= htmlspecialchars($groupe['description'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="couleur" class="form-label fw-bold">Couleur</label>
                    <input
                        type="text"
                        name="couleur"
                        id="couleur"
                        class="form-control"
                        value="<?= htmlspecialchars($groupe['couleur'] ?? '') ?>"
                    >
                </div>

                <?php if (!empty($budget)): ?>
                    <div class="card-soft p-3 mt-4">
                        <small class="text-muted">Budget du groupe</small>
                        <div class="fw-bold">
                            <?= number_format((float) $budget['montant_total'], 2, ',', ' ') ?> €
                        </div>
                        <div class="text-muted small">
                            Utilisé :
                            <?= number_format((float) $budget['montant_utilise'], 2, ',', ' ') ?> €
                        </div>
                    </div>
                <?php endif; ?>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-check-circle me-2"></i>
                        Enregistrer
                    </button>

                    <a href="routeur.php?page=groupes" class="btn btn-light rounded-pill px-4">
                        Annuler
                    </a>
                </div>

            </form>

        </div>

    </div>
</main>