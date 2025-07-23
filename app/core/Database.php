<?php
namespace app\core;

use PDO;
use PDOException;

class Database {
    private static $pdo = null;

    public static function connect() {
        if (self::$pdo === null) {
            $host = "c0tme.h.filess.io";
            $port = 61000; // Filess.io port
            $dbname = "COSC4806001JS2_figurewhom";
            $username = "COSC4806001JS2_figurewhom";
            $password = $_ENV['PASS']; // Secret from Replit

            try {
                $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
                self::$pdo = new PDO($dsn, $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
