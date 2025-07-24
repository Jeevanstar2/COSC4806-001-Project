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
<p style="text-align:right;">
    You are browsing as 
    <strong><?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['username']) : 'Guest' ?></strong>. 
    <?php if (!isset($_SESSION['user'])): ?>
        <a href="index.php?action=login">Login</a> or 
        <a href="index.php?action=register">Register</a>
    <?php else: ?>
        <a href="index.php?action=logout">Logout</a>
    <?php endif; ?>
</p>
<h1><?= htmlspecialchars($title) ?> (<?= htmlspecialchars($year) ?>)</h1>
<?php if ($poster): ?>
    <img src="<?= htmlspecialchars($poster) ?>" alt="Poster">
<?php endif; ?>
<p><strong>Genre:</strong> <?= htmlspecialchars($genre) ?></p>
<p><strong>Plot:</strong> <?= htmlspecialchars($plot) ?></p>
<form method="POST" action="index.php?action=rate">
    <input type="hidden" name="movie_id" value="<?= $movieId ?>">
    <input type="hidden" name="movie_title" value="<?= htmlspecialchars($title) ?>">
    <label>Rate this movie:</label>
    <select name="rating">
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?>/5</option>
        <?php endfor; ?>
    </select>
    <button type="submit">Submit Rating</button>
</form>
<p><strong>Average Rating:</strong> <?= $avg ?>/5 (<?= $votes ?> votes)</p>
<form method="POST" action="index.php?action=review">
    <input type="hidden" name="movie_title" value="<?= htmlspecialchars($title) ?>">
    <button type="submit">Get AI Review</button>
</form>
<h3>AI Review:</h3>
<p><?= htmlspecialchars($review ?? "No review yet.") ?></p>
<p><a href="index.php">← Back to Search</a></p>