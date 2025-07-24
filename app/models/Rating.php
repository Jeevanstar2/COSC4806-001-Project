<?php
namespace app\models;
use app\core\Database;
use PDO;
class Rating 
{
    public static function add($movieId, $rating) 
    {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO ratings (movie_id, rating) VALUES (?, ?)");
        return $stmt->execute([$movieId, $rating]);
    }
    public static function getAverage($movieId) 
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT AVG(rating) as avg_rating FROM ratings WHERE movie_id = ?");
        $stmt->execute([$movieId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['avg_rating'] !== null ? round($result['avg_rating'], 2) : 0;
    }
    public static function getCount($movieId) 
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM ratings WHERE movie_id = ?");
        $stmt->execute([$movieId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int) $result['total'] : 0;
    }
}