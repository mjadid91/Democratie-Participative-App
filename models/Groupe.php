<?php

require_once "Model.php";

class Groupe extends Model
{
    protected static string $table = "groupe";
    protected static string $primaryKey = "id_groupe";

    public static function getByUser(int $idUtilisateur): array
    {
        $sql = "
            SELECT DISTINCT g.*
            FROM groupe g
            JOIN role_dans_groupe rdg ON rdg.id_groupe = g.id_groupe
            WHERE rdg.id_utilisateur = :id_utilisateur
            ORDER BY g.date_creation DESC
        ";

        $stmt = self::pdo()->prepare($sql);
        $stmt->execute(['id_utilisateur' => $idUtilisateur]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(
        string $nom,
        string $description,
        string $couleur,
        ?string $image,
        int $idCreateur
    ): int|false {
        $sql = "
            INSERT INTO groupe (nom, description, couleur, image, id_createur)
            VALUES (:nom, :description, :couleur, :image, :id_createur)
        ";

        $stmt = self::pdo()->prepare($sql);

        $success = $stmt->execute([
            'nom' => trim($nom),
            'description' => trim($description),
            'couleur' => trim($couleur),
            'image' => $image,
            'id_createur' => $idCreateur
        ]);

        return $success ? (int) self::pdo()->lastInsertId() : false;
    }

    public static function updateGroupe(
        int $idGroupe,
        string $nom,
        string $description,
        string $couleur,
        ?string $image
    ): bool {
        $sql = "
            UPDATE groupe
            SET nom = :nom,
                description = :description,
                couleur = :couleur,
                image = :image
            WHERE id_groupe = :id_groupe
        ";

        $stmt = self::pdo()->prepare($sql);

        return $stmt->execute([
            'id_groupe' => $idGroupe,
            'nom' => $nom,
            'description' => trim($description),
            'couleur' => trim($couleur),
            'image' => $image
        ]);
    }
}