<main class="page-section">
    <div class="container">

        <div class="page-header">
            <span class="page-kicker">Création</span>
            <h1 class="page-title">Créer un groupe</h1>
            <p class="page-description">
                Crée un espace participatif avec un budget dédié pour accueillir des propositions citoyennes.
            </p>
        </div>

        <div class="auth-card" style="max-width: 760px;">

            <form method="post" action="routeur.php?page=groupes&action=creer">

                <div class="mb-3">
                    <label for="nom" class="form-label fw-bold">Nom du groupe</label>
                    <input
                        type="text"
                        name="nom"
                        id="nom"
                        class="form-control"
                        placeholder="Ex : Mobilité urbaine"
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
                        placeholder="Explique l’objectif du groupe..."
                    ></textarea>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="couleur" class="form-label fw-bold">Couleur</label>
                        <input
                            type="text"
                            name="couleur"
                            id="couleur"
                            class="form-control"
                            placeholder="Ex : Bleu"
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="montant_total" class="form-label fw-bold">Budget total (€)</label>
                        <input
                            type="number"
                            name="montant_total"
                            id="montant_total"
                            class="form-control"
                            min="1"
                            step="0.01"
                            placeholder="Ex : 15000"
                            required
                        >
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-plus-circle me-2"></i>
                        Créer le groupe
                    </button>

                    <a href="routeur.php?page=groupes" class="btn btn-light rounded-pill px-4">
                        Annuler
                    </a>
                </div>

            </form>

        </div>

    </div>
</main>