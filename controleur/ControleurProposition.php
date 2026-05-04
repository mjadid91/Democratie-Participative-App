<?php

require_once "models/Utilisateur.php";
require_once "models/Groupe.php";
require_once "models/Budget.php";
require_once "models/Proposition.php";
require_once "models/Commentaire.php";
require_once "models/ReactionCommentaire.php";
require_once "models/Vote.php";
require_once "models/RoleDansGroupe.php";

class ControleurProposition
{
    public static function index(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $idGroupe = (int) ($_GET['id_groupe'] ?? 0);

        $groupe = Groupe::find($idGroupe);

        if (!$groupe) {
            $_SESSION['erreur'] = "Groupe introuvable.";
            header("Location: routeur.php?page=groupes");
            exit;
        }

        $budget = Budget::getByGroupe($idGroupe);
        $propositions = Proposition::getByGroupe($idGroupe);

        include "vue/layout/debut.php";
        include "vue/pages/proposition/index.php";
        include "vue/layout/fin.php";
    }

    public static function details(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $idProposition = (int) ($_GET['id_proposition'] ?? 0);
        $proposition = Proposition::find($idProposition);

        if (!$proposition) {
            $_SESSION['erreur'] = "Proposition introuvable.";
            header("Location: routeur.php?page=groupes");
            exit;
        }

        $commentaires = Commentaire::getByProposition($idProposition);
        $vote = Vote::getByProposition($idProposition);
        $resultatsVote = $vote ? Vote::getResultats((int) $vote['id_vote']) : [];

        include "vue/layout/debut.php";
        include "vue/pages/proposition/details.php";
        include "vue/layout/fin.php";
    }

    public static function formulaireCreation(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $idGroupe = (int) ($_GET['id_groupe'] ?? 0);
        $groupe = Groupe::find($idGroupe);

        if (!$groupe) {
            $_SESSION['erreur'] = "Groupe introuvable.";
            header("Location: routeur.php?page=groupes");
            exit;
        }

        $budget = Budget::getByGroupe($idGroupe);

        include "vue/layout/debut.php";
        include "vue/pages/proposition/create.php";
        include "vue/layout/fin.php";
    }

    public static function creer(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $user = Utilisateur::current();

        $data = [
            'id_groupe' => (int) ($_POST['id_groupe'] ?? 0),
            'id_utilisateur' => (int) $user['id_utilisateur'],
            'id_budget' => !empty($_POST['id_budget']) ? (int) $_POST['id_budget'] : null,
            'titre' => $_POST['titre'] ?? '',
            'description' => $_POST['description'] ?? '',
            'montant_demande' => (float) ($_POST['montant_demande'] ?? 0),
            'date_fin' => $_POST['date_fin'] ?? null,
        ];

        $idProposition = Proposition::create($data);

        if (!$idProposition) {
            $_SESSION['erreur'] = "Impossible de créer la proposition.";
            header("Location: routeur.php?page=propositions&action=formulaireCreation&id_groupe=" . $data['id_groupe']);
            exit;
        }

        RoleDansGroupe::addRole((int) $user['id_utilisateur'], $data['id_groupe'], 5);

        $_SESSION['success'] = "Proposition créée.";
        header("Location: routeur.php?page=propositions&id_groupe=" . $data['id_groupe']);
        exit;
    }

    public static function formulaireModification(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $idProposition = (int) ($_GET['id_proposition'] ?? 0);
        $proposition = Proposition::find($idProposition);

        if (!$proposition) {
            $_SESSION['erreur'] = "Proposition introuvable.";
            header("Location: routeur.php?page=groupes");
            exit;
        }

        include "vue/layout/debut.php";
        include "vue/pages/proposition/edit.php";
        include "vue/layout/fin.php";
    }

    public static function modifier(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $idProposition = (int) ($_POST['id_proposition'] ?? 0);
        $idGroupe = (int) ($_POST['id_groupe'] ?? 0);

        if ($idProposition <= 0 || $idGroupe <= 0) {
            $_SESSION['erreur'] = "Données invalides.";
            header("Location: routeur.php?page=groupes");
            exit;
        }

        $success = Proposition::update([
            'id_proposition' => $idProposition,
            'titre' => $_POST['titre'] ?? '',
            'description' => $_POST['description'] ?? '',
            'montant_demande' => $_POST['montant_demande'] ?? 0,
            'date_fin' => $_POST['date_fin'] ?? null,
        ]);

        if (!$success) {
            $_SESSION['erreur'] = "Erreur lors de la modification.";
            header("Location: routeur.php?page=propositions&action=details&id_proposition=$idProposition");
            exit;
        }

        $_SESSION['success'] = "Proposition modifiée.";
        header("Location: routeur.php?page=propositions&action=details&id_proposition=$idProposition");
        exit;
    }

    public static function ajouterCommentaire(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $user = Utilisateur::current();

        $idProposition = (int) ($_POST['id_proposition'] ?? 0);
        $texte = $_POST['texte'] ?? '';

        $idCommentaire = Commentaire::create($idProposition, (int) $user['id_utilisateur'], $texte);

        if (!$idCommentaire) {
            $_SESSION['erreur'] = "Commentaire vide ou invalide.";
        } else {
            $_SESSION['success'] = "Commentaire publié.";
        }

        header("Location: routeur.php?page=propositions&action=details&id_proposition=$idProposition");
        exit;
    }

    public static function supprimerCommentaire(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $user = Utilisateur::current();

        $idCommentaire = (int) ($_POST['id_commentaire'] ?? 0);
        $idProposition = (int) ($_POST['id_proposition'] ?? 0);

        Commentaire::softDelete($idCommentaire, (int) $user['id_utilisateur']);

        $_SESSION['success'] = "Commentaire supprimé.";
        header("Location: routeur.php?page=propositions&action=details&id_proposition=$idProposition");
        exit;
    }

    public static function ajouterReaction(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $user = Utilisateur::current();

        $idCommentaire = (int) ($_POST['id_commentaire'] ?? 0);
        $idProposition = (int) ($_POST['id_proposition'] ?? 0);
        $type = $_POST['type_reaction'] ?? '';

        ReactionCommentaire::toggle(
            $idCommentaire,
            (int) $user['id_utilisateur'],
            $type
        );

        header("Location: routeur.php?page=propositions&action=details&id_proposition=$idProposition");
        exit;
    }

    public static function creerVote(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $idProposition = (int) ($_POST['id_proposition'] ?? 0);
        $typeVote = $_POST['type_vote'] ?? 'majoritaire';
        $dateDebut = date('Y-m-d H:i:s');
        $dateFin = $_POST['date_fin'] ?? '';

        if ($idProposition <= 0 || $dateFin === '') {
            $_SESSION['erreur'] = "Données du vote invalides.";
            header("Location: routeur.php?page=propositions&action=details&id_proposition=$idProposition");
            exit;
        }

        Vote::create($idProposition, $typeVote, $dateDebut, $dateFin);
        Proposition::updateStatut($idProposition, 'en_vote');

        $_SESSION['success'] = "Vote créé.";
        header("Location: routeur.php?page=propositions&action=details&id_proposition=$idProposition");
        exit;
    }

    public static function soumettreVote(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $user = Utilisateur::current();

        $idVote = (int) ($_POST['id_vote'] ?? 0);
        $idProposition = (int) ($_POST['id_proposition'] ?? 0);
        $choix = $_POST['choix'] ?? '';

        Vote::submitVote($idVote, (int) $user['id_utilisateur'], $choix);

        $_SESSION['success'] = "Vote enregistré.";
        header("Location: routeur.php?page=propositions&action=details&id_proposition=$idProposition");
        exit;
    }
}