<?php

require_once "Model.php";

class ReactionCommentaire extends Model
{
    protected static string $table = "reaction_commentaire";
    protected static string $primaryKey = "id_commentaire";

    public static function toggle(int $idCommentaire, int $idUtilisateur, string $typeReaction): bool
    {
        $typesAutorises = ['like', 'dislike', 'love', 'haha', 'sad'];

        if (!in_array($typeReaction, $typesAutorises, true)) {
            return false;
        }

        $pdo = self::pdo();

        $sqlCheck = "
            SELECT type_reaction
            FROM reaction_commentaire
            WHERE id_commentaire = :id_commentaire
            AND id_utilisateur = :id_utilisateur
        ";

        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([
            'id_commentaire' => $idCommentaire,
            'id_utilisateur' => $idUtilisateur
        ]);

        $reactionExistante = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($reactionExistante && $reactionExistante['type_reaction'] === $typeReaction) {
            $sqlDelete = "
                DELETE FROM reaction_commentaire
                WHERE id_commentaire = :id_commentaire
                AND id_utilisateur = :id_utilisateur
            ";

            $stmtDelete = $pdo->prepare($sqlDelete);

            return $stmtDelete->execute([
                'id_commentaire' => $idCommentaire,
                'id_utilisateur' => $idUtilisateur
            ]);
        }

        $sql = "
            INSERT INTO reaction_commentaire (
                id_commentaire,
                id_utilisateur,
                type_reaction
            )
            VALUES (
                :id_commentaire,
                :id_utilisateur,
                :type_reaction
            )
            ON DUPLICATE KEY UPDATE
                type_reaction = VALUES(type_reaction),
                date_reaction = CURRENT_TIMESTAMP
        ";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            'id_commentaire' => $idCommentaire,
            'id_utilisateur' => $idUtilisateur,
            'type_reaction' => $typeReaction
        ]);
    }
}