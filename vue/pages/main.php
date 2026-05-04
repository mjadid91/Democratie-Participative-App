<main class="hero-section">
    <div class="container">

        <div class="text-center">

            <span class="hero-badge">
                <i class="bi bi-stars"></i>
                Plateforme citoyenne
            </span>

            <h1 class="hero-title">
                Ta voix compte vraiment.
            </h1>

            <p class="hero-text mx-auto">
                Propose, débat, vote. Une plateforme simple pour participer aux décisions.
            </p>

            <div class="mt-4">

                <?php if (!empty($_SESSION['utilisateur'])): ?>

                    <a href="routeur.php?page=groupes" class="btn btn-primary btn-lg">
                        <i class="bi bi-people"></i> Mes groupes
                    </a>

                <?php else: ?>

                    <a href="routeur.php?page=inscription" class="btn btn-primary btn-lg me-2">
                        S'inscrire
                    </a>

                    <a href="routeur.php?page=connexion" class="btn btn-light btn-lg">
                        Connexion
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>
</main>