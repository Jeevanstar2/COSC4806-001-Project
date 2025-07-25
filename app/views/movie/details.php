<?php
use App\Models\Rating;
require_once __DIR__ . '/../../models/Rating.php';
require_once __DIR__ . '/../../core/Database.php';
$title = $movie['Title'] ?? 'Unknown Title';
$year = $movie['Year'] ?? 'N/A';
$poster = $movie['Poster'] ?? '';
$genre = $movie['Genre'] ?? 'N/A';
$plot = $movie['Plot'] ?? 'No plot available.';
$movieId = $movie['id'] ?? 0;
$avg = Rating::getAverage($movieId);
$votes = Rating::getCount($movieId);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($title) ?> - Details</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <header class="navbar">
        <div class="logo"><a href="index.php" style="color: inherit; text-decoration: none;">🎬 CineReview</a></div>
        <nav>
            <ul>
                <li><a href="index.php?action=search">Search</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><span style="color:#fff;">Hello, <?= htmlspecialchars($_SESSION['user']['username']) ?></span></li>
                    <li><a href="index.php?action=logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="index.php?action=login">Login</a></li>
                    <li><a href="index.php?action=register">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="movie-card">
            <div class="movie-poster">
                <?php if ($poster): ?>
                    <img src="<?= htmlspecialchars($poster) ?>" alt="Poster">
                <?php endif; ?>
            </div>
            <div class="movie-info">
                <h1><?= htmlspecialchars($title) ?> (<?= htmlspecialchars($year) ?>)</h1>
                <p><strong>Genre:</strong> <?= htmlspecialchars($genre) ?></p>
                <p><strong>Plot:</strong> <?= htmlspecialchars($plot) ?></p>
                <form method="POST" action="index.php?action=rate">
                    <input type="hidden" name="movie_id" value="<?= $movieId ?>">
                    <input type="hidden" name="movie_title" value="<?= htmlspecialchars($title) ?>">
                    <label>Rate this movie:</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                        <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                        <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                        <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                        <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                    </div>
                    <button type="submit">Submit Rating</button>
                </form>
                <?php
                $rounded = round($avg);
                ?>
                <p class="rating-summary"><strong>Average Rating:</strong> <?= $avg ?>/5 (<?= $votes ?> vote<?= $votes == 1 ? '' : 's' ?>)
                    <span class="avg-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star<?= $i <= $rounded ? ' filled' : '' ?>">★</span>
                        <?php endfor; ?>
                    </span>
                </p>
                <form method="POST" action="index.php?action=review">
                    <input type="hidden" name="movie_title" value="<?= htmlspecialchars($title) ?>">
                    <button type="submit">Get AI Review</button>
                </form>
                <h3>AI Review:</h3>
                <p><?= htmlspecialchars($review ?? "No review yet.") ?></p>
                <p><a href="index.php?action=search">← Back to Search</a></p>
            </div>
        </div>
    </div>
</body>
</html>