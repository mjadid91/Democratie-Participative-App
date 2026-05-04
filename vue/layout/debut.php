<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Démocratie Participative</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/app.css">
</head>

<body class="app-body">

<?php include "vue/layout/menu.php"; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            <?= htmlspecialchars($_SESSION['success']) ?>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['erreur'])): ?>
    <div class="container mt-4">
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <?= htmlspecialchars($_SESSION['erreur']) ?>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['erreur']); ?>
<?php endif; ?>