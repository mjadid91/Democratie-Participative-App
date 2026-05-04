<?php

require_once "models/Utilisateur.php";
require_once "models/Invitation.php";
require_once "models/RoleDansGroupe.php";

class ControleurInvitation
{
    public static function inviter(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $user = Utilisateur::current();

        $idGroupe = (int) ($_POST['id_groupe'] ?? 0);
        $email = trim($_POST['email_invite'] ?? '');

        if ($idGroupe <= 0 || $email === '') {
            $_SESSION['erreur'] = "Invitation invalide.";
            header("Location: routeur.php?page=groupes");
            exit;
        }

        if (!RoleDansGroupe::hasRole((int) $user['id_utilisateur'], $idGroupe, 'Administrateur')) {
            $_SESSION['erreur'] = "Vous n'avez pas les droits pour inviter.";
            header("Location: routeur.php?page=propositions&id_groupe=$idGroupe");
            exit;
        }

        $idInvitation = Invitation::create($idGroupe, (int) $user['id_utilisateur'], $email);

        $_SESSION[$idInvitation ? 'success' : 'erreur'] =
            $idInvitation ? "Invitation créée." : "Email invalide ou invitation impossible.";

        header("Location: routeur.php?page=propositions&id_groupe=$idGroupe");
        exit;
    }

    public static function accepter(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $user = Utilisateur::current();
        $idInvitation = (int) ($_GET['id_invitation'] ?? 0);
        $invitation = Invitation::getById($idInvitation);

        if (!$invitation || $invitation['statut'] !== 'en_attente') {
            $_SESSION['erreur'] = "Invitation invalide ou déjà traitée.";
            header("Location: routeur.php?page=groupes");
            exit;
        }

        Invitation::updateStatut($idInvitation, 'acceptee');
        RoleDansGroupe::addRole((int) $user['id_utilisateur'], (int) $invitation['id_groupe'], 2);

        $_SESSION['success'] = "Invitation acceptée.";
        header("Location: routeur.php?page=groupes");
        exit;
    }

    public static function refuser(): void
    {
        $idInvitation = (int) ($_GET['id_invitation'] ?? 0);
        Invitation::updateStatut($idInvitation, 'refusee');

        $_SESSION['success'] = "Invitation refusée.";
        header("Location: routeur.php?page=groupes");
        exit;
    }
}