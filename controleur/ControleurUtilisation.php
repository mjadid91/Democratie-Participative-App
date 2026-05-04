<?php

require_once "models/Utilisateur.php";

class ControleurUtilisateur
{
    public static function profil(): void
    {
        if (!Utilisateur::isConnected()) {
            header("Location: routeur.php?page=connexion");
            exit;
        }

        $utilisateur = Utilisateur::current();

        include "vue/layout/debut.php";
        include "vue/pages/utilisateur/profil.php";
        include "vue/layout/fin.php";
    }
}