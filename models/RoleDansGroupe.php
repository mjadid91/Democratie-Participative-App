<?php

require_once "Model.php";

class RoleDansGroupe extends Model
{
    protected static string $table = "role_dans_groupe";
    protected static string $primaryKey = "id_utilisateur";

    public static function hasRole(int $idUtilisateur, int $idGroupe, string $role): bool
    {
        $sql = "
            SELECT COUNT(*)
            FROM role_dans_groupe rdg
            JOIN role r ON r.id_role = rdg.id_role
            WHERE rdg.id_utilisateur = :id_utilisateur
            AND rdg.id_groupe = :id_groupe
            AND r.nom = :role
        ";

        $stmt = self::pdo()->prepare($sql);

        $stmt->execute([
            'id_utilisateur' => $idUtilisateur,
            'id_groupe' => $idGroupe,
            'role' => $role
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public static function isAdmin(int $idUtilisateur, int $idGroupe): bool
    {
        return self::hasRole($idUtilisateur, $idGroupe, 'Administrateur');
    }

    public static function isMembre(int $idUtilisateur, int $idGroupe): bool
    {
        return self::hasRole($idUtilisateur, $idGroupe, 'Membre');
    }

    public static function isModerateur(int $idUtilisateur, int $idGroupe): bool
    {
        return self::hasRole($idUtilisateur, $idGroupe, 'Moderateur');
    }

    public static function isInGroup(int $idUtilisateur, int $idGroupe): bool
    {
        $sql = "
            SELECT COUNT(*)
            FROM role_dans_groupe
            WHERE id_utilisateur = :id_utilisateur
            AND id_groupe = :id_groupe
        ";

        $stmt = self::pdo()->prepare($sql);

        $stmt->execute([
            'id_utilisateur' => $idUtilisateur,
            'id_groupe' => $idGroupe
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public static function addRole(int $idUtilisateur, int $idGroupe, int $idRole): bool
    {
        $sql = "
            INSERT IGNORE INTO role_dans_groupe (
                id_utilisateur,
                id_groupe,
                id_role
            )
            VALUES (
                :id_utilisateur,
                :id_groupe,
                :id_role
            )
        ";

        $stmt = self::pdo()->prepare($sql);

        return $stmt->execute([
            'id_utilisateur' => $idUtilisateur,
            'id_groupe' => $idGroupe,
            'id_role' => $idRole
        ]);
    }

    public static function removeFromGroup(int $idUtilisateur, int $idGroupe): bool
    {
        $sql = "
            DELETE FROM role_dans_groupe
            WHERE id_utilisateur = :id_utilisateur
            AND id_groupe = :id_groupe
        ";

        $stmt = self::pdo()->prepare($sql);

        return $stmt->execute([
            'id_utilisateur' => $idUtilisateur,
            'id_groupe' => $idGroupe
        ]);
    }
}