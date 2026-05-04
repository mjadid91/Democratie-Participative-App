<?php

require_once "Model.php";

class Budget extends Model
{
    protected static string $table = "budget";
    protected static string $primaryKey = "id_budget";

    public static function getByGroupe(int $idGroupe): ?array
    {
        $sql = "
            SELECT *,
                   (montant_total - montant_utilise) AS montant_disponible
            FROM budget
            WHERE id_groupe = :id_groupe
            LIMIT 1
        ";

        $stmt = self::pdo()->prepare($sql);
        $stmt->execute(['id_groupe' => $idGroupe]);

        $budget = $stmt->fetch(PDO::FETCH_ASSOC);

        return $budget ?: null;
    }

    public static function create(int $idGroupe, string $nom, float $montantTotal): int|false
    {
        if ($montantTotal <= 0) {
            return false;
        }

        $sql = "
            INSERT INTO budget (id_groupe, nom, montant_total, montant_utilise)
            VALUES (:id_groupe, :nom, :montant_total, 0)
        ";

        $stmt = self::pdo()->prepare($sql);

        $success = $stmt->execute([
            'id_groupe' => $idGroupe,
            'nom' => trim($nom),
            'montant_total' => $montantTotal
        ]);

        return $success ? (int) self::pdo()->lastInsertId() : false;
    }
}