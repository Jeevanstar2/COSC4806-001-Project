<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($movie['Title']) ?></title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <h1><?= htmlspecialchars($movie['Title']) ?> (<?= $movie['Year'] ?>)</h1>
    <img src="<?= $movie['Poster'] ?>" alt="Poster" width="200"><br>
    <strong>Genre:</strong> <?= $movie['Genre'] ?><br>
    <strong>Plot:</strong> <?= $movie['Plot'] ?><br><br>

    <form method="POST" action="index.php?action=rate">
        <input type="hidden" name="movie_id" value="<?= $movie['imdbID'] ?>">
        <input type="hidden" name="movie_title" value="<?= htmlspecialchars($movie['Title']) ?>">
        <label>Rate this movie:</label>
        <select name="rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?>/5</option>
            <?php endfor; ?>
        </select>
        <button type="submit">Submit Rating</button>
    </form>

    <?php
    $avg = \App\Models\Rating::getAverage($movie['imdbID']);
    $count = \App\Models\Rating::getCount($movie['imdbID']);
    ?>
    <p><strong>Average Rating:</strong> <?= $avg ?>/5 (<?= $count ?> votes)</p>

    <form method="POST" action="index.php?action=review">
        <input type="hidden" name="movie_title" value="<?= htmlspecialchars($movie['Title']) ?>">
        <button type="submit">Get AI Review</button>
    </form>

    <?php if (!empty($review)): ?>
        <h3>AI Review:</h3>
        <p><?= nl2br(htmlspecialchars($review)) ?></p>
    <?php endif; ?>

    <br><a href="index.php">← Back to Search</a>
</body>
</html>
