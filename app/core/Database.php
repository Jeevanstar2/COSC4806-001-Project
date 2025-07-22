<?php
namespace App\Core;

class Database {
    private static $pdo = null;

    public static function connect() {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../../config/config.php';

            try {
                self::$pdo = new \PDO(
                    "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
                    $config['username'],
                    $config['password']
                );
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
