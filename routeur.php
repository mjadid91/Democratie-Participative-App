<?php

session_start();

require_once __DIR__ . "/config/Connexion.php";

Connexion::connect();

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . "/modele/" . $class . ".php",
        __DIR__ . "/controleur/" . $class . ".php",
    ];

    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$page = $_GET['page'] ?? $_POST['page'] ?? 'main';
$action = $_GET['action'] ?? $_POST['action'] ?? 'affichage';

$routes = [
    'main' => [
        'affichage' => [ControleurMain::class, 'affichage'],
    ],

    'connexion' => [
        'affichage' => [ControleurAuth::class, 'afficherConnexion'],
        'connecter' => [ControleurAuth::class, 'connecter'],
    ],

    'inscription' => [
        'affichage' => [ControleurAuth::class, 'afficherInscription'],
        'inscrire' => [ControleurAuth::class, 'inscrire'],
    ],

    'deconnexion' => [
        'affichage' => [ControleurAuth::class, 'deconnecter'],
    ],

    'utilisateur' => [
        'profil' => [ControleurUtilisateur::class, 'profil'],
    ],

    'groupes' => [
        'affichage' => [ControleurGroupe::class, 'index'],
        'formulaireCreation' => [ControleurGroupe::class, 'formulaireCreation'],
        'creer' => [ControleurGroupe::class, 'creer'],
        'formulaireModification' => [ControleurGroupe::class, 'formulaireModification'],
        'modifier' => [ControleurGroupe::class, 'modifier'],
    ],

    'propositions' => [
        'affichage' => [ControleurProposition::class, 'index'],
        'details' => [ControleurProposition::class, 'details'],
        'formulaireCreation' => [ControleurProposition::class, 'formulaireCreation'],
        'creer' => [ControleurProposition::class, 'creer'],
        'ajouterCommentaire' => [ControleurProposition::class, 'ajouterCommentaire'],
        'supprimerCommentaire' => [ControleurProposition::class, 'supprimerCommentaire'],
        'ajouterReaction' => [ControleurProposition::class, 'ajouterReaction'],
        'creerVote' => [ControleurProposition::class, 'creerVote'],
        'soumettreVote' => [ControleurProposition::class, 'soumettreVote'],
        'formulaireModification' => [ControleurProposition::class, 'formulaireModification'],
        'modifier' => [ControleurProposition::class, 'modifier'],
    ],

    'invitation' => [
        'inviter' => [ControleurInvitation::class, 'inviter'],
        'accepter' => [ControleurInvitation::class, 'accepter'],
        'refuser' => [ControleurInvitation::class, 'refuser'],
    ],

    'signalements' => [
        'affichage' => [ControleurSignalement::class, 'index'],
        'signalerCommentaire' => [ControleurSignalement::class, 'signalerCommentaire'],
        'signalerProposition' => [ControleurSignalement::class, 'signalerProposition'],
        'traiter' => [ControleurSignalement::class, 'traiter'],
        'rejeter' => [ControleurSignalement::class, 'rejeter'],
    ],
];

if (!isset($routes[$page][$action])) {
    http_response_code(404);

    include "vue/layout/debut.php";
    echo "<main class='page-section'>
            <div class='container'>
                <div class='premium-card text-center py-5'>
                    <h1 class='page-title'>404</h1>
                    <p class='text-muted'>Page ou action introuvable.</p>
                    <a href='routeur.php?page=main' class='btn btn-primary rounded-pill px-4 mt-3'>
                        Retour à l’accueil
                    </a>
                </div>
            </div>
        </main>";
    include "vue/layout/fin.php";
}

[$controller, $method] = $routes[$page][$action];
$controller::$method();