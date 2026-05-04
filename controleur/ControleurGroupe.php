<?php

require_once "models/Utilisateur.php";
require_once "models/Groupe.php";
require_once "models/Budget.php";
require_once "models/RoleDansGroupe.php";

class ControleurGroupe
{
    public static function index(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $user = Utilisateur::current();
        $groupes = Groupe::getByUser((int) $user['id_utilisateur']);

        include "vue/layout/debut.php";
        include "vue/pages/groupe/index.php";
        include "vue/layout/fin.php";
    }

    public static function formulaireCreation(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        include "vue/layout/debut.php";
        include "vue/pages/groupe/create.php";
        include "vue/layout/fin.php";
    }

    public static function creer(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $user = Utilisateur::current();

        $nom = trim($_POST['nom'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $couleur = trim($_POST['couleur'] ?? '');
        $montantTotal = (float) ($_POST['montant_total'] ?? 0);

        if ($nom === '' || $montantTotal <= 0) {
            $_SESSION['erreur'] = "Nom du groupe ou budget invalide.";
            header("Location: routeur.php?page=groupes&action=formulaireCreation");
            exit;
        }

        $idGroupe = Groupe::create(
            $nom,
            $description,
            $couleur,
            null,
            (int) $user['id_utilisateur']
        );

        if (!$idGroupe) {
            $_SESSION['erreur'] = "Erreur lors de la création du groupe.";
            header("Location: routeur.php?page=groupes&action=formulaireCreation");
            exit;
        }

        Budget::create($idGroupe, "Budget principal", $montantTotal);

        // 1 = Administrateur
        RoleDansGroupe::addRole((int) $user['id_utilisateur'], $idGroupe, 1);

        $_SESSION['success'] = "Groupe créé avec succès.";
        header("Location: routeur.php?page=groupes");
        exit;
    }

    public static function formulaireModification(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $idGroupe = (int) ($_GET['id_groupe'] ?? 0);
        $groupe = Groupe::find($idGroupe);
        $budget = Budget::getByGroupe($idGroupe);

        if (!$groupe) {
            $_SESSION['erreur'] = "Groupe introuvable.";
            header("Location: routeur.php?page=groupes");
            exit;
        }

        include "vue/layout/debut.php";
        include "vue/pages/groupe/edit.php";
        include "vue/layout/fin.php";
    }

    public static function modifier(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $user = Utilisateur::current();
        $idGroupe = (int) ($_POST['id_groupe'] ?? 0);

        if ($idGroupe <= 0) {
            $_SESSION['erreur'] = "Groupe invalide.";
            header("Location: routeur.php?page=groupes");
            exit;
        }

        if (!RoleDansGroupe::hasRole((int) $user['id_utilisateur'], $idGroupe, 'Administrateur')) {
            $_SESSION['erreur'] = "Vous n'avez pas les droits pour modifier ce groupe.";
            header("Location: routeur.php?page=groupes");
            exit;
        }

        $success = Groupe::updateGroupe(
            $idGroupe,
            $_POST['nom'] ?? '',
            $_POST['description'] ?? '',
            $_POST['couleur'] ?? '',
            null
        );

        if (!$success) {
            $_SESSION['erreur'] = "Erreur lors de la modification du groupe.";
            header("Location: routeur.php?page=groupes&action=formulaireModification&id_groupe=$idGroupe");
            exit;
        }

        $_SESSION['success'] = "Groupe modifié avec succès.";
        header("Location: routeur.php?page=groupes");
        exit;
    }
}