<?php
$user = $utilisateur ?? ($_SESSION['utilisateur'] ?? null);
?>

<main class="page-section">
    <div class="container">

        <div class="page-header">
            <span class="page-kicker">Mon espace</span>
            <h1 class="page-title">Mon profil</h1>
            <p class="page-description">
                Retrouve ici tes informations personnelles et ton activité sur la plateforme.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-lg-4">
                <div class="premium-card text-center">
                    <div class="auth-icon mx-auto">
                        <i class="bi bi-person"></i>
                    </div>

                    <h3 class="fw-black mb-1">
                        <?= htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?>
                    </h3>

                    <p class="text-muted mb-3">
                        @<?= htmlspecialchars($user['login'] ?? 'utilisateur') ?>
                    </p>

                    <span class="badge-soft">
                        <i class="bi bi-check-circle me-1"></i>
                        Compte actif
                    </span>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="premium-card">
                    <h4 class="fw-bold mb-4">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        Informations personnelles
                    </h4>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="card-soft p-3">
                                <small class="text-muted">Prénom</small>
                                <div class="fw-bold">
                                    <?= htmlspecialchars($user['prenom'] ?? 'Non renseigné') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-soft p-3">
                                <small class="text-muted">Nom</small>
                                <div class="fw-bold">
                                    <?= htmlspecialchars($user['nom'] ?? 'Non renseigné') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-soft p-3">
                                <small class="text-muted">Email</small>
                                <div class="fw-bold">
                                    <?= htmlspecialchars($user['email'] ?? 'Non renseigné') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-soft p-3">
                                <small class="text-muted">Login</small>
                                <div class="fw-bold">
                                    <?= htmlspecialchars($user['login'] ?? 'Non renseigné') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-soft p-3">
                                <small class="text-muted">Ville</small>
                                <div class="fw-bold">
                                    <?= htmlspecialchars($user['ville'] ?? 'Non renseigné') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-soft p-3">
                                <small class="text-muted">Code postal</small>
                                <div class="fw-bold">
                                    <?= htmlspecialchars($user['code_postal'] ?? 'Non renseigné') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card-soft p-3">
                                <small class="text-muted">Adresse</small>
                                <div class="fw-bold">
                                    <?= htmlspecialchars($user['adresse'] ?? 'Non renseigné') ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <a href="routeur.php?page=groupes" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-people me-2"></i>
                            Voir mes groupes
                        </a>

                        <a href="routeur.php?page=deconnexion" class="btn btn-light rounded-pill px-4">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Déconnexion
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</main>