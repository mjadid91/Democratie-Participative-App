<?php

require_once "Model.php";

class Signalement extends Model
{
    protected static string $table = "signalement";
    protected static string $primaryKey = "id_signalement";

    public static function getAllPending(): array
    {
        $sql = "
            SELECT 
                s.*,
                signaleur.login AS login_signaleur,
                signaleur.nom AS nom_signaleur,
                signaleur.prenom AS prenom_signaleur,
                c.texte AS texte_commentaire,
                p.titre AS titre_proposition
            FROM signalement s
            JOIN utilisateur signaleur ON signaleur.id_utilisateur = s.id_signaleur
            LEFT JOIN commentaire c ON c.id_commentaire = s.id_commentaire
            LEFT JOIN proposition p ON p.id_proposition = s.id_proposition
            WHERE s.statut = 'en_attente'
            ORDER BY s.date_signalement DESC
        ";

        $stmt = self::pdo()->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function signalerCommentaire(
        int $idSignaleur,
        int $idCommentaire,
        string $motif
    ): int|false {
        $motif = trim($motif);

        if ($motif === '') {
            return false;
        }

        $sql = "
            INSERT INTO signalement (
                id_signaleur,
                id_commentaire,
                id_proposition,
                motif
            )
            VALUES (
                :id_signaleur,
                :id_commentaire,
                NULL,
                :motif
            )
        ";

        $stmt = self::pdo()->prepare($sql);

        $success = $stmt->execute([
            'id_signaleur' => $idSignaleur,
            'id_commentaire' => $idCommentaire,
            'motif' => $motif
        ]);

        return $success ? (int) self::pdo()->lastInsertId() : false;
    }

    public static function signalerProposition(
        int $idSignaleur,
        int $idProposition,
        string $motif
    ): int|false {
        $motif = trim($motif);

        if ($motif === '') {
            return false;
        }

        $sql = "
            INSERT INTO signalement (
                id_signaleur,
                id_commentaire,
                id_proposition,
                motif
            )
            VALUES (
                :id_signaleur,
                NULL,
                :id_proposition,
                :motif
            )
        ";

        $stmt = self::pdo()->prepare($sql);

        $success = $stmt->execute([
            'id_signaleur' => $idSignaleur,
            'id_proposition' => $idProposition,
            'motif' => $motif
        ]);

        return $success ? (int) self::pdo()->lastInsertId() : false;
    }

    public static function traiter(int $idSignalement): bool
    {
        return self::updateStatut($idSignalement, 'traite');
    }

    public static function rejeter(int $idSignalement): bool
    {
        return self::updateStatut($idSignalement, 'rejete');
    }

    private static function updateStatut(int $idSignalement, string $statut): bool
    {
        $statutsAutorises = ['en_attente', 'traite', 'rejete'];

        if (!in_array($statut, $statutsAutorises, true)) {
            return false;
        }

        $sql = "
            UPDATE signalement
            SET statut = :statut
            WHERE id_signalement = :id_signalement
        ";

        $stmt = self::pdo()->prepare($sql);

        return $stmt->execute([
            'id_signalement' => $idSignalement,
            'statut' => $statut
        ]);
    }
}