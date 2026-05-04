<main class="page-section">
    <div class="container">

        <div class="page-header">
            <span class="page-kicker">Modification</span>
            <h1 class="page-title">Modifier la proposition</h1>
            <p class="page-description">
                Mets à jour le titre, la description, le montant demandé ou la date de fin.
            </p>
        </div>

        <div class="auth-card" style="max-width: 820px;">

            <form method="post" action="routeur.php?page=propositions&action=modifier">

                <input type="hidden" name="id_proposition" value="<?= (int) $proposition['id_proposition'] ?>">
                <input type="hidden" name="id_groupe" value="<?= (int) $proposition['id_groupe'] ?>">

                <div class="mb-3">
                    <label for="titre" class="form-label fw-bold">Titre</label>
                    <input
                        type="text"
                        name="titre"
                        id="titre"
                        class="form-control"
                        value="<?= htmlspecialchars($proposition['titre'] ?? '') ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="5"
                        required
                    ><?= htmlspecialchars($proposition['description'] ?? '') ?></textarea>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="montant_demande" class="form-label fw-bold">Montant demandé (€)</label>
                        <input
                            type="number"
                            name="montant_demande"
                            id="montant_demande"
                            class="form-control"
                            min="0"
                            step="0.01"
                            value="<?= htmlspecialchars($proposition['montant_demande'] ?? 0) ?>"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="date_fin" class="form-label fw-bold">Date de fin</label>
                        <input
                            type="date"
                            name="date_fin"
                            id="date_fin"
                            class="form-control"
                            value="<?= !empty($proposition['date_fin']) ? htmlspecialchars(substr($proposition['date_fin'], 0, 10)) : '' ?>"
                        >
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-check-circle me-2"></i>
                        Enregistrer
                    </button>

                    <a href="routeur.php?page=propositions&action=details&id_proposition=<?= (int) $proposition['id_proposition'] ?>"
                       class="btn btn-light rounded-pill px-4">
                        Annuler
                    </a>
                </div>

            </form>

        </div>

    </div>
</main>