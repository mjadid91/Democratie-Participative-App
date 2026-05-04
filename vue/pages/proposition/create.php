<main class="page-section">
    <div class="container">

        <div class="page-header">
            <span class="page-kicker">Nouvelle idée</span>
            <h1 class="page-title">Créer une proposition</h1>
            <p class="page-description">
                Décris clairement ton idée, le budget demandé et la date limite de participation.
            </p>
        </div>

        <div class="auth-card" style="max-width: 820px;">

            <form method="post" action="routeur.php?page=propositions&action=creer">

                <input type="hidden" name="id_groupe" value="<?= (int) $idGroupe ?>">
                <input type="hidden" name="id_budget" value="<?= !empty($budget['id_budget']) ? (int) $budget['id_budget'] : '' ?>">

                <div class="mb-3">
                    <label for="titre" class="form-label fw-bold">Titre de la proposition</label>
                    <input
                        type="text"
                        name="titre"
                        id="titre"
                        class="form-control"
                        placeholder="Ex : Ajouter des pistes cyclables"
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
                        placeholder="Explique le problème, ta solution et l’impact attendu..."
                        required
                    ></textarea>
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
                            placeholder="Ex : 3500"
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
                        >
                    </div>

                </div>

                <?php if (!empty($budget)): ?>
                    <div class="card-soft p-3 mt-4">
                        <div class="d-flex justify-content-between flex-wrap gap-3">
                            <div>
                                <small class="text-muted">Budget disponible</small>
                                <div class="fw-bold text-success">
                                    <?= number_format((float) ($budget['montant_disponible'] ?? 0), 2, ',', ' ') ?> €
                                </div>
                            </div>

                            <div>
                                <small class="text-muted">Budget total</small>
                                <div class="fw-bold">
                                    <?= number_format((float) ($budget['montant_total'] ?? 0), 2, ',', ' ') ?> €
                                </div>
                            </div>

                            <div>
                                <small class="text-muted">Budget utilisé</small>
                                <div class="fw-bold">
                                    <?= number_format((float) ($budget['montant_utilise'] ?? 0), 2, ',', ' ') ?> €
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-send me-2"></i>
                        Publier la proposition
                    </button>

                    <a href="routeur.php?page=propositions&id_groupe=<?= (int) $idGroupe ?>" class="btn btn-light rounded-pill px-4">
                        Annuler
                    </a>
                </div>

            </form>

        </div>

    </div>
</main>