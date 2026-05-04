<?php

abstract class Model
{
    protected static string $table;
    protected static string $primaryKey;

    protected static function pdo(): PDO
    {
        return Connexion::pdo();
    }

    public static function find(int $id): ?array
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = :id";
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public static function all(): array
    {
        $sql = "SELECT * FROM " . static::$table . " ORDER BY " . static::$primaryKey . " DESC";
        $stmt = self::pdo()->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete(int $id): bool
    {
        $sql = "DELETE FROM " . static::$table . " WHERE " . static::$primaryKey . " = :id";
        $stmt = self::pdo()->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}