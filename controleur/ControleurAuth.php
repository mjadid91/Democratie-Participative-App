<?php

require_once "models/Utilisateur.php";

class ControleurAuth
{
    public static function afficherConnexion(): void
    {
        include "vue/layout/debut.php";
        include "vue/pages/utilisateur/connexion.php";
        include "vue/layout/fin.php";
    }

    public static function connecter(): void
    {
        $login = trim($_POST['login'] ?? '');
        $password = $_POST['mot_de_passe'] ?? '';

        if ($login === '' || $password === '') {
            $_SESSION['erreur'] = "Login ou mot de passe manquant.";
            header("Location: routeur.php?page=connexion");
            exit;
        }

        if (Utilisateur::login($login, $password)) {
            $_SESSION['success'] = "Connexion réussie.";
            header("Location: routeur.php?page=groupes");
            exit;
        }

        $_SESSION['erreur'] = "Login ou mot de passe incorrect.";
        header("Location: routeur.php?page=connexion");
        exit;
    }

    public static function afficherInscription(): void
    {
        include "vue/layout/debut.php";
        include "vue/pages/utilisateur/inscription.php";
        include "vue/layout/fin.php";
    }

    public static function inscrire(): void
    {
        $data = [
            'login' => $_POST['login'] ?? '',
            'nom' => $_POST['nom'] ?? '',
            'prenom' => $_POST['prenom'] ?? '',
            'email' => $_POST['email'] ?? '',
            'mot_de_passe' => $_POST['mot_de_passe'] ?? '',
            'adresse' => $_POST['adresse'] ?? null,
            'ville' => $_POST['ville'] ?? null,
            'code_postal' => $_POST['code_postal'] ?? null,
        ];

        if (
            trim($data['login']) === '' ||
            trim($data['nom']) === '' ||
            trim($data['prenom']) === '' ||
            trim($data['email']) === '' ||
            trim($data['mot_de_passe']) === ''
        ) {
            $_SESSION['erreur'] = "Tous les champs obligatoires doivent être remplis.";
            header("Location: routeur.php?page=inscription");
            exit;
        }

        $id = Utilisateur::register($data);

        if (!$id) {
            $_SESSION['erreur'] = "Impossible de créer le compte. Login ou email déjà utilisé.";
            header("Location: routeur.php?page=inscription");
            exit;
        }

        $_SESSION['success'] = "Compte créé. Vous pouvez maintenant vous connecter.";
        header("Location: routeur.php?page=connexion");
        exit;
    }

    public static function deconnecter(): void
    {
        Utilisateur::logout();
        $_SESSION['success'] = "Déconnexion réussie.";
        header("Location: routeur.php?page=main");
        exit;
    }
}