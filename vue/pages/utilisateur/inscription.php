<main class="auth-section">
    <div class="container">

        <div class="auth-card" style="max-width: 720px;">

            <div class="auth-icon">
                <i class="bi bi-person-plus"></i>
            </div>

            <h1 class="auth-title">Créer un compte</h1>

            <p class="auth-text">
                Rejoins la plateforme pour créer des propositions, commenter et voter dans tes groupes.
            </p>

            <form method="post" action="routeur.php?page=inscription&action=inscrire">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="prenom" class="form-label fw-bold">Prénom</label>
                        <input
                            type="text"
                            name="prenom"
                            id="prenom"
                            class="form-control"
                            placeholder="Mohamed"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="nom" class="form-label fw-bold">Nom</label>
                        <input
                            type="text"
                            name="nom"
                            id="nom"
                            class="form-control"
                            placeholder="Jadid"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="login" class="form-label fw-bold">Login</label>
                        <input
                            type="text"
                            name="login"
                            id="login"
                            class="form-control"
                            placeholder="mjadid"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            placeholder="mohamed@email.com"
                            required
                        >
                    </div>

                    <div class="col-12">
                        <label for="mot_de_passe" class="form-label fw-bold">Mot de passe</label>
                        <input
                            type="password"
                            name="mot_de_passe"
                            id="mot_de_passe"
                            class="form-control"
                            placeholder="Choisis un mot de passe sécurisé"
                            required
                        >
                    </div>

                    <div class="col-12">
                        <label for="adresse" class="form-label fw-bold">Adresse</label>
                        <input
                            type="text"
                            name="adresse"
                            id="adresse"
                            class="form-control"
                            placeholder="12 rue de Paris"
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="ville" class="form-label fw-bold">Ville</label>
                        <input
                            type="text"
                            name="ville"
                            id="ville"
                            class="form-control"
                            placeholder="Paris"
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="code_postal" class="form-label fw-bold">Code postal</label>
                        <input
                            type="text"
                            name="code_postal"
                            id="code_postal"
                            class="form-control"
                            placeholder="75000"
                        >
                    </div>

                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg rounded-pill mt-4">
                    <i class="bi bi-person-check me-2"></i>
                    Créer mon compte
                </button>

            </form>

            <div class="text-center mt-4">
                <span class="text-muted">Déjà un compte ?</span>
                <a href="routeur.php?page=connexion" class="fw-bold">
                    Se connecter
                </a>
            </div>

        </div>

    </div>
</main>