<?php

require_once "Model.php";

class Commentaire extends Model
{
    protected static string $table = "commentaire";
    protected static string $primaryKey = "id_commentaire";

    public static function getByProposition(int $idProposition): array
    {
        $sql = "
            SELECT 
                c.id_commentaire,
                c.texte,
                c.date_commentaire,
                c.est_supprime,
                u.id_utilisateur,
                u.login,
                u.nom,
                u.prenom,
                COUNT(r.id_utilisateur) AS total_reactions
            FROM commentaire c
            JOIN utilisateur u ON u.id_utilisateur = c.id_utilisateur
            LEFT JOIN reaction_commentaire r ON r.id_commentaire = c.id_commentaire
            WHERE c.id_proposition = :id_proposition
            GROUP BY c.id_commentaire
            ORDER BY c.date_commentaire ASC
        ";

        $stmt = self::pdo()->prepare($sql);
        $stmt->execute(['id_proposition' => $idProposition]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(int $idProposition, int $idUtilisateur, string $texte): int|false
    {
        $texte = trim($texte);

        if ($texte === '') {
            return false;
        }

        $sql = "
            INSERT INTO commentaire (id_proposition, id_utilisateur, texte)
            VALUES (:id_proposition, :id_utilisateur, :texte)
        ";

        $stmt = self::pdo()->prepare($sql);

        $success = $stmt->execute([
            'id_proposition' => $idProposition,
            'id_utilisateur' => $idUtilisateur,
            'texte' => $texte
        ]);

        return $success ? (int) self::pdo()->lastInsertId() : false;
    }

    public static function softDelete(int $idCommentaire, int $idUtilisateur): bool
    {
        $sql = "
            UPDATE commentaire
            SET est_supprime = 1
            WHERE id_commentaire = :id_commentaire
            AND id_utilisateur = :id_utilisateur
        ";

        $stmt = self::pdo()->prepare($sql);

        return $stmt->execute([
            'id_commentaire' => $idCommentaire,
            'id_utilisateur' => $idUtilisateur
        ]);
    }
}