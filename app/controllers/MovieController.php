<?php
namespace app\controllers;

use app\models\Movie;
use app\models\Rating;

class MovieController {
    public function index() {
        require __DIR__ . '/../views/movie/index.php';
    }

    public function search() {
        $title = $_GET['title'] ?? '';
        $movie = Movie::findByTitle($title);  // ✅ Corrected method
        $review = "";
        require __DIR__ . '/../views/movie/details.php';
    }

    public function rate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieId = $_POST['movie_id'];
            $rating = (int) $_POST['rating'];

            if ($movieId && $rating >= 1 && $rating <= 5) {
                Rating::add($movieId, $rating);
            }

            $title = urlencode($_POST['movie_title']);
            header("Location: index.php?action=search&title=$title");
            exit;
        }
    }

    public function review() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieTitle = $_POST['movie_title'];
            $prompt = "Write a short, fun, and friendly movie review for the film titled '{$movieTitle}'.";

            $apiKey = $_ENV['GEMINI_API'] ?? getenv('GEMINI_API');

            if (!$apiKey) {
                $review = "❌ Gemini API key is missing. Set GEMINI_API in Replit secrets.";
                $movie = \app\models\Movie::findByTitle($movieTitle); // ✅ Corrected namespace and method
                require __DIR__ . '/../views/movie/details.php';
                return;
            }

            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

            $payload = [
                "contents" => [
                    [
                        "parts" => [
                            ["text" => $prompt]
                        ]
                    ]
                ]
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if (!$response) {
                $review = "❌ cURL error: " . $error;
            } else {
                $data = json_decode($response, true);
                $review = $data['candidates'][0]['content']['parts'][0]['text'] ?? "⚠️ Could not generate a review.";
            }

            $movie = \app\models\Movie::findByTitle($movieTitle); // ✅ Corrected namespace and method
            require __DIR__ . '/../views/movie/details.php';
        }
    }
}
