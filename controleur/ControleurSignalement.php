<?php

require_once "models/Utilisateur.php";
require_once "models/Signalement.php";
require_once "models/Commentaire.php";
require_once "models/Proposition.php";


class ControleurSignalement
{
    public static function index(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $signalements = Signalement::getAllPending();

        include "vue/layout/debut.php";
        include "vue/pages/moderation/signalements.php";
        include "vue/layout/fin.php";
    }

    public static function signalerCommentaire(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $user = Utilisateur::current();

        $idCommentaire = (int) ($_POST['id_commentaire'] ?? 0);
        $idProposition = (int) ($_POST['id_proposition'] ?? 0);
        $motif = $_POST['motif'] ?? '';

        Signalement::signalerCommentaire((int) $user['id_utilisateur'], $idCommentaire, $motif);

        $_SESSION['success'] = "Signalement envoyé.";
        header("Location: routeur.php?page=propositions&action=details&id_proposition=$idProposition");
        exit;
    }

    public static function signalerProposition(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $user = Utilisateur::current();

        $idProposition = (int) ($_POST['id_proposition'] ?? 0);
        $motif = $_POST['motif'] ?? '';

        Signalement::signalerProposition((int) $user['id_utilisateur'], $idProposition, $motif);

        $_SESSION['success'] = "Signalement envoyé.";
        header("Location: routeur.php?page=propositions&action=details&id_proposition=$idProposition");
        exit;
    }

    public static function traiter(): void
    {
        $idSignalement = (int) ($_POST['id_signalement'] ?? 0);
        Signalement::traiter($idSignalement);

        $_SESSION['success'] = "Signalement traité.";
        header("Location: routeur.php?page=signalements");
        exit;
    }

    public static function rejeter(): void
    {
        $idSignalement = (int) ($_POST['id_signalement'] ?? 0);
        Signalement::rejeter($idSignalement);

        $_SESSION['success'] = "Signalement rejeté.";
        header("Location: routeur.php?page=signalements");
        exit;
    }
}
?>