<?php

require_once "Model.php";

class Vote extends Model
{
    protected static string $table = "vote";
    protected static string $primaryKey = "id_vote";

    public static function getByProposition(int $idProposition): ?array
    {
        $sql = "
            SELECT *
            FROM vote
            WHERE id_proposition = :id_proposition
            ORDER BY date_debut DESC
            LIMIT 1
        ";

        $stmt = self::pdo()->prepare($sql);
        $stmt->execute(['id_proposition' => $idProposition]);

        $vote = $stmt->fetch(PDO::FETCH_ASSOC);

        return $vote ?: null;
    }

    public static function create(int $idProposition, string $typeVote, string $dateDebut, string $dateFin): int|false
    {
        $sql = "
            INSERT INTO vote (id_proposition, type_vote, date_debut, date_fin)
            VALUES (:id_proposition, :type_vote, :date_debut, :date_fin)
        ";

        $stmt = self::pdo()->prepare($sql);

        $success = $stmt->execute([
            'id_proposition' => $idProposition,
            'type_vote' => $typeVote,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin
        ]);

        return $success ? (int) self::pdo()->lastInsertId() : false;
    }

    public static function submitVote(int $idVote, int $idUtilisateur, string $choix): bool
    {
        if (!in_array($choix, ['pour', 'contre', 'abstention'], true)) {
            return false;
        }

        $sql = "
            INSERT INTO vote_utilisateur (id_vote, id_utilisateur, choix)
            VALUES (:id_vote, :id_utilisateur, :choix)
            ON DUPLICATE KEY UPDATE choix = VALUES(choix), date_vote = CURRENT_TIMESTAMP
        ";

        $stmt = self::pdo()->prepare($sql);

        return $stmt->execute([
            'id_vote' => $idVote,
            'id_utilisateur' => $idUtilisateur,
            'choix' => $choix
        ]);
    }

    public static function getResultats(int $idVote): array
    {
        $sql = "
            SELECT choix, COUNT(*) AS total
            FROM vote_utilisateur
            WHERE id_vote = :id_vote
            AND est_valide = 1
            GROUP BY choix
        ";

        $stmt = self::pdo()->prepare($sql);
        $stmt->execute(['id_vote' => $idVote]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}