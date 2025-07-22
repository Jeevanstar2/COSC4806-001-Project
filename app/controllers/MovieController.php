<?php
namespace App\Controllers;

use App\Models\Movie;
use App\Models\Rating;

class MovieController {
    public function index() {
        // Show the search form
        require __DIR__ . '/../views/movie/index.php';
    }

    public function search() {
        $title = $_GET['title'] ?? '';
        $movie = Movie::fetchByTitle($title);
        $review = ""; // Placeholder in case review was previously generated

        require __DIR__ . '/../views/movie/details.php';
    }

    public function rate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieId = $_POST['movie_id'];
            $rating = (int) $_POST['rating'];

            if ($movieId && $rating >= 1 && $rating <= 5) {
                Rating::add($movieId, $rating);
            }

            // Redirect back to movie details
            $title = urlencode($_POST['movie_title']);
            header("Location: index.php?action=search&title=$title");
            exit;
        }
    }

    public function review() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieTitle = $_POST['movie_title'];

            $prompt = "Write a short, fun and friendly movie review for the film titled '{$movieTitle}'.";

            // Use your Replit secret name exactly: GEMINI_API
            $apiKey = $_ENV['GEMINI_API'] ?? getenv('GEMINI_API');

            if (!$apiKey) {
                $review = "❌ Gemini API key is missing. Set GEMINI_API in Replit secrets.";
                $movie = \App\Models\Movie::fetchByTitle($movieTitle);
                require __DIR__ . '/../views/movie/details.php';
                return;
            }

            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$apiKey}";

            $payload = [
                "contents" => [
                    [
                        "parts" => [
                            ["text" => $prompt]
                        ]
                    ]
                ]
            ];

            $options = [
                'http' => [
                    'method' => 'POST',
                    'header' => "Content-Type: application/json",
                    'content' => json_encode($payload)
                ]
            ];

            $context = stream_context_create($options);
            $response = @file_get_contents($url, false, $context);

            if (!$response) {
                $review = "⚠️ Error: Gemini API request failed.";
            } else {
                $data = json_decode($response, true);
                $review = $data['candidates'][0]['content']['parts'][0]['text'] ?? "⚠️ Could not generate a review.";
            }

            $movie = \App\Models\Movie::fetchByTitle($movieTitle);
            require __DIR__ . '/../views/movie/details.php';
        }
    }
}
