<main class="page-section">
    <div class="container">

        <div class="page-header">
            <span class="page-kicker">Vote</span>
            <h1 class="page-title">Créer un vote</h1>
            <p class="page-description">
                Définis le type de vote et sa date de fin pour permettre aux membres de participer.
            </p>
        </div>

        <div class="auth-card" style="max-width: 720px;">

            <form method="post" action="routeur.php?page=propositions&action=creerVote">

                <input type="hidden" name="id_proposition" value="<?= (int) $idProposition ?>">

                <div class="mb-3">
                    <label for="type_vote" class="form-label fw-bold">Type de vote</label>
                    <select name="type_vote" id="type_vote" class="form-select" required>
                        <option value="majoritaire">Majoritaire</option>
                        <option value="consultatif">Consultatif</option>
                        <option value="decisif">Décisif</option>
                        <option value="unanime">Unanime</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="date_fin" class="form-label fw-bold">Date de fin du vote</label>
                    <input
                        type="datetime-local"
                        name="date_fin"
                        id="date_fin"
                        class="form-control"
                        required
                    >
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-bar-chart me-2"></i>
                        Lancer le vote
                    </button>

                    <a href="routeur.php?page=propositions&action=details&id_proposition=<?= (int) $idProposition ?>"
                       class="btn btn-light rounded-pill px-4">
                        Annuler
                    </a>
                </div>

            </form>

        </div>

    </div>
</main>