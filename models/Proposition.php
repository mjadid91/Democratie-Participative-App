<?php

require_once "Model.php";
require_once "Budget.php";

class Proposition extends Model
{
    protected static string $table = "proposition";
    protected static string $primaryKey = "id_proposition";

    public static function getByGroupe(int $idGroupe): array
    {
        $sql = "
            SELECT 
                p.*,
                u.login,
                u.nom,
                u.prenom,
                b.nom AS nom_budget
            FROM proposition p
            JOIN utilisateur u ON u.id_utilisateur = p.id_utilisateur
            LEFT JOIN budget b ON b.id_budget = p.id_budget
            WHERE p.id_groupe = :id_groupe
            ORDER BY p.date_soumission DESC
        ";

        $stmt = self::pdo()->prepare($sql);
        $stmt->execute(['id_groupe' => $idGroupe]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(array $data): int|false
    {
        $titre = trim($data['titre'] ?? '');
        $description = trim($data['description'] ?? '');
        $montant = (float) ($data['montant_demande'] ?? 0);

        if ($titre === '' || $description === '') {
            return false;
        }

        $sql = "
            INSERT INTO proposition (
                id_groupe,
                id_utilisateur,
                id_budget,
                titre,
                description,
                montant_demande,
                statut,
                date_fin
            )
            VALUES (
                :id_groupe,
                :id_utilisateur,
                :id_budget,
                :titre,
                :description,
                :montant_demande,
                'en_attente',
                :date_fin
            )
        ";

        $stmt = self::pdo()->prepare($sql);

        $success = $stmt->execute([
            'id_groupe' => (int) $data['id_groupe'],
            'id_utilisateur' => (int) $data['id_utilisateur'],
            'id_budget' => !empty($data['id_budget']) ? (int) $data['id_budget'] : null,
            'titre' => $titre,
            'description' => $description,
            'montant_demande' => $montant,
            'date_fin' => $data['date_fin'] ?? null
        ]);

        return $success ? (int) self::pdo()->lastInsertId() : false;
    }

    public static function updateStatut(int $idProposition, string $statut): bool
    {
        $statutsAutorises = [
            'en_attente',
            'approuvee',
            'rejetee',
            'en_vote',
            'adoptee',
            'refusee',
            'realisee'
        ];

        if (!in_array($statut, $statutsAutorises, true)) {
            return false;
        }

        $sql = "
            UPDATE proposition
            SET statut = :statut
            WHERE id_proposition = :id_proposition
        ";

        $stmt = self::pdo()->prepare($sql);

        return $stmt->execute([
            'statut' => $statut,
            'id_proposition' => $idProposition
        ]);
    }

    public static function update(array $data): bool
{
    $sql = "
        UPDATE proposition
        SET titre = :titre,
            description = :description,
            montant_demande = :montant_demande,
            date_fin = :date_fin
        WHERE id_proposition = :id_proposition
    ";

    $stmt = self::pdo()->prepare($sql);

    return $stmt->execute([
        'id_proposition' => (int) $data['id_proposition'],
        'titre' => trim($data['titre']),
        'description' => trim($data['description']),
        'montant_demande' => (float) $data['montant_demande'],
        'date_fin' => !empty($data['date_fin']) ? $data['date_fin'] : null,
    ]);
}
}