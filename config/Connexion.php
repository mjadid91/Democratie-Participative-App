<?php

require_once __DIR__ . "/Config.php";

class Connexion
{
    private static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            self::connect();
        }

        return self::$pdo;
    }

    public static function connect(): void
    {
        try {
            self::$pdo = new PDO(
                "mysql:host=" . HOSTNAME . ";dbname=" . DATABASE . ";charset=utf8mb4",
                LOGIN,
                PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
}