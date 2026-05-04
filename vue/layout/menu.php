<?php
$user = $_SESSION['utilisateur'] ?? null;
$page = $_GET['page'] ?? 'main';
?>

<header class="app-header">
    <nav class="navbar navbar-expand-lg app-navbar">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center gap-2" href="routeur.php?page=main">
                <div class="brand-logo">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                <div>
                    <span class="brand-title">Agora</span>
                    <span class="brand-subtitle">Participative</span>
                </div>
            </a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="nav" class="collapse navbar-collapse">

                <ul class="navbar-nav mx-auto">

                    <li class="nav-item">
                        <a class="nav-link <?= $page === 'main' ? 'active' : '' ?>" href="routeur.php?page=main">
                            <i class="bi bi-house"></i> Accueil
                        </a>
                    </li>

                    <?php if ($user): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $page === 'groupes' ? 'active' : '' ?>" href="routeur.php?page=groupes">
                                <i class="bi bi-people"></i> Groupes
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= $page === 'signalements' ? 'active' : '' ?>" href="routeur.php?page=signalements">
                                <i class="bi bi-shield"></i> Signalements
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>

                <ul class="navbar-nav ms-auto">

                    <?php if ($user): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-pill" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>
                                <?= htmlspecialchars($user['login'] ?? 'User') ?>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow rounded-4">
                                <li>
                                    <a class="dropdown-item" href="routeur.php?page=utilisateur&action=profil">
                                        <i class="bi bi-person"></i> Profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="routeur.php?page=deconnexion">
                                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>

                        <li class="nav-item">
                            <a class="btn btn-outline-primary me-2" href="routeur.php?page=connexion">
                                Connexion
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="btn btn-primary" href="routeur.php?page=inscription">
                                Inscription
                            </a>
                        </li>

                    <?php endif; ?>

                </ul>

            </div>
        </div>
    </nav>
</header>