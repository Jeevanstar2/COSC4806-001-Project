<?php
namespace app\models;

class Movie {
    public static function findByTitle($title) {
        $apiKey = $_ENV['OMDB_API'];
        $url = "http://www.omdbapi.com/?apikey={$apiKey}&t=" . urlencode($title);
        $response = file_get_contents($url);

        if ($response === false) {
            return null;
        }

        return json_decode($response, true);
    }
}
