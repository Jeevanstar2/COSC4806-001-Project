<?php
namespace app\models;

use app\core\Database;
use PDO;

class Movie {
    public static function findByTitle($title) {
        $apiKey = $_ENV['OMDB_API'] ?? getenv('OMDB_API');

        if (!$apiKey) {
            return null;
        }

        $url = "https://www.omdbapi.com/?t=" . urlencode($title) . "&apikey=" . $apiKey;
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (!$data || $data['Response'] === 'False') {
            return null;
        }

        // Check if movie already exists in DB, if not, insert it
        $db = Database::connect();
        $stmt = $db->prepare("SELECT id FROM movies WHERE title = ?");
        $stmt->execute([$data['Title']]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $movieId = $existing['id'];
        } else {
            $insert = $db->prepare("INSERT INTO movies (title, year, poster, genre, plot) VALUES (?, ?, ?, ?, ?)");
            $insert->execute([
                $data['Title'],
                $data['Year'] ?? '',
                $data['Poster'] ?? '',
                $data['Genre'] ?? '',
                $data['Plot'] ?? ''
            ]);
            $movieId = $db->lastInsertId();
        }

        // Add movie ID to the movie array
        $data['id'] = $movieId;

        return $data;
    }
}
