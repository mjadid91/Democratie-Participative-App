<?php

require_once "Model.php";

class Utilisateur extends Model
{
    protected static string $table = "utilisateur";
    protected static string $primaryKey = "id_utilisateur";

    public static function isConnected(): bool
    {
        return isset($_SESSION['utilisateur']);
    }

    public static function current(): ?array
    {
        return $_SESSION['utilisateur'] ?? null;
    }

    public static function logout(): void
    {
        unset($_SESSION['utilisateur']);
    }

    public static function findByLogin(string $login): ?array
    {
        $sql = "SELECT * FROM utilisateur WHERE login = :login LIMIT 1";
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute(['login' => $login]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public static function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM utilisateur WHERE email = :email LIMIT 1";
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public static function register(array $data): int|false
    {
        $login = trim($data['login'] ?? '');
        $email = trim($data['email'] ?? '');
        $nom = trim($data['nom'] ?? '');
        $prenom = trim($data['prenom'] ?? '');
        $password = $data['mot_de_passe'] ?? '';

        // Validation de base
        if (
            $login === '' ||
            $nom === '' ||
            $prenom === '' ||
            $email === '' ||
            $password === '' ||
            !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            return false;
        }

        // Vérifier unicité
        if (self::findByLogin($login) || self::findByEmail($email)) {
            return false;
        }

        $sql = "
            INSERT INTO utilisateur (
                login,
                nom,
                prenom,
                email,
                mot_de_passe,
                adresse,
                ville,
                code_postal
            )
            VALUES (
                :login,
                :nom,
                :prenom,
                :email,
                :mot_de_passe,
                :adresse,
                :ville,
                :code_postal
            )
        ";

        $stmt = self::pdo()->prepare($sql);

        $success = $stmt->execute([
            'login' => $login,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'mot_de_passe' => password_hash($password, PASSWORD_DEFAULT),
            'adresse' => !empty($data['adresse']) ? trim($data['adresse']) : null,
            'ville' => !empty($data['ville']) ? trim($data['ville']) : null,
            'code_postal' => !empty($data['code_postal']) ? trim($data['code_postal']) : null
        ]);

        return $success ? (int) self::pdo()->lastInsertId() : false;
    }

    public static function login(string $login, string $password): bool
    {
        $login = trim($login);

        if ($login === '' || $password === '') {
            return false;
        }

        $user = self::findByLogin($login);

        if (!$user || !password_verify($password, $user['mot_de_passe'])) {
            return false;
        }

        // On enlève le mot de passe de la session (important)
        unset($user['mot_de_passe']);

        $_SESSION['utilisateur'] = $user;

        return true;
    }
}