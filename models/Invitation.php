<?php

require_once "Model.php";

class Invitation extends Model
{
    protected static string $table = "invitation";
    protected static string $primaryKey = "id_invitation";

    public static function getById(int $idInvitation): ?array
    {
        return self::find($idInvitation);
    }

    public static function getByGroupe(int $idGroupe): array
    {
        $sql = "
            SELECT 
                i.*,
                u.login AS login_inviteur,
                u.nom AS nom_inviteur,
                u.prenom AS prenom_inviteur,
                g.nom AS nom_groupe
            FROM invitation i
            JOIN utilisateur u ON u.id_utilisateur = i.id_inviteur
            JOIN groupe g ON g.id_groupe = i.id_groupe
            WHERE i.id_groupe = :id_groupe
            ORDER BY i.date_invitation DESC
        ";

        $stmt = self::pdo()->prepare($sql);
        $stmt->execute(['id_groupe' => $idGroupe]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(int $idGroupe, int $idInviteur, string $emailInvite): int|false
    {
        if (!filter_var($emailInvite, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $sql = "
            INSERT INTO invitation (id_groupe, id_inviteur, email_invite)
            VALUES (:id_groupe, :id_inviteur, :email_invite)
        ";

        $stmt = self::pdo()->prepare($sql);

        $success = $stmt->execute([
            'id_groupe' => $idGroupe,
            'id_inviteur' => $idInviteur,
            'email_invite' => trim($emailInvite)
        ]);

        return $success ? (int) self::pdo()->lastInsertId() : false;
    }

    public static function updateStatut(int $idInvitation, string $statut): bool
    {
        $statutsAutorises = ['en_attente', 'acceptee', 'refusee', 'expiree'];

        if (!in_array($statut, $statutsAutorises, true)) {
            return false;
        }

        $sql = "
            UPDATE invitation
            SET statut = :statut
            WHERE id_invitation = :id_invitation
        ";

        $stmt = self::pdo()->prepare($sql);

        return $stmt->execute([
            'id_invitation' => $idInvitation,
            'statut' => $statut
        ]);
    }

    public static function expirerAnciennesInvitations(): bool
    {
        $sql = "
            UPDATE invitation
            SET statut = 'expiree'
            WHERE statut = 'en_attente'
            AND date_invitation < DATE_SUB(NOW(), INTERVAL 7 DAY)
        ";

        return self::pdo()->exec($sql) !== false;
    }
}