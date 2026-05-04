<?php

class ControleurMain
{
    public static function affichage(): void
    {
        include "vue/layout/debut.php";
        include "vue/pages/main.php";
        include "vue/layout/fin.php";
    }
}