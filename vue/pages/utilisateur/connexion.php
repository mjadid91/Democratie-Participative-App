<main class="auth-section">
    <div class="container">

        <div class="auth-card">

            <div class="auth-icon">
                <i class="bi bi-box-arrow-in-right"></i>
            </div>

            <h1 class="auth-title">Connexion</h1>

            <p class="auth-text">
                Connecte-toi pour accéder à tes groupes, proposer des idées et participer aux votes.
            </p>

            <form method="post" action="routeur.php?page=connexion&action=connecter">

                <div class="mb-3">
                    <label for="login" class="form-label fw-bold">Login</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-4">
                            <i class="bi bi-person"></i>
                        </span>
                        <input
                            type="text"
                            name="login"
                            id="login"
                            class="form-control rounded-end-4"
                            placeholder="ex: dupontj"
                            required
                        >
                    </div>
                </div>

                <div class="mb-4">
                    <label for="mot_de_passe" class="form-label fw-bold">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-4">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input
                            type="password"
                            name="mot_de_passe"
                            id="mot_de_passe"
                            class="form-control rounded-end-4"
                            placeholder="Ton mot de passe"
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg rounded-pill">
                    <i class="bi bi-unlock me-2"></i>
                    Se connecter
                </button>

            </form>

            <div class="text-center mt-4">
                <span class="text-muted">Pas encore de compte ?</span>
                <a href="routeur.php?page=inscription" class="fw-bold">
                    Créer un compte
                </a>
            </div>

        </div>

    </div>
</main>