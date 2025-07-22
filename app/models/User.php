<?php
namespace App\Models;

use App\Core\Database;

class User {
    public static function findByUsername($username) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM people WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public static function create($username, $hashedPassword) {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare("INSERT INTO people (username, password) VALUES (?, ?)");
            return $stmt->execute([$username, $hashedPassword]);
        } catch (\PDOException $e) {
            return false;
        }
    }
}
