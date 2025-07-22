<?php
namespace App\Controllers;

use App\Models\Movie;
use App\Models\Rating;

class MovieController {
    public function index() {
        require __DIR__ . '/../views/movie/index.php';
    }

    public function search() {
        $title = $_GET['title'] ?? '';
        $movie = Movie::fetchByTitle($title);

        require __DIR__ . '/../views/movie/details.php';
    }

    public function rate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieId = $_POST['movie_id'];
            $rating = (int) $_POST['rating'];

            if ($movieId && $rating >= 1 && $rating <= 5) {
                Rating::add($movieId, $rating);
            }

            // Redirect back to search page with movie title
            header("Location: index.php?action=search&title=" . urlencode($_POST['movie_title']));
            exit;
        }
    }

    public function review() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieTitle = $_POST['movie_title'];

            $prompt = "Write a short, enthusiastic movie review for '{$movieTitle}'.";
            $apiKey = $_ENV['GEMINI_API'];

            $payload = [
                "contents" => [[ "parts" => [[ "text" => $prompt ]]]]
            ];

            $response = file_get_contents(
                "https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key={$apiKey}",
                false,
                stream_context_create([
                    'http' => [
                        'method' => 'POST',
                        'header' => "Content-Type: application/json",
                        'content' => json_encode($payload)
                    ]
                ])
            );

            $data = json_decode($response, true);
            $review = $data['candidates'][0]['content']['parts'][0]['text'] ?? "Error generating review.";

            $movie = Movie::fetchByTitle($movieTitle);
            require __DIR__ . '/../views/movie/details.php';
        }
    }
}
