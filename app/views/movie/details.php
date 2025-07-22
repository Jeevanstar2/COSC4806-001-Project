<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($movie['Title']) ?> - Movie Details</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <div class="container">
        <!-- Show login or guest message -->
        <?php if (isset($_SESSION['user'])): ?>
            <p>Logged in as <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong> | <a href="index.php?action=logout">Logout</a></p>
        <?php else: ?>
            <p>You are browsing as <strong>Guest</strong>. <a href="index.php?action=loginForm">Login</a> or <a href="index.php?action=registerForm">Register</a></p>
        <?php endif; ?>

        <h1><?= htmlspecialchars($movie['Title']) ?> (<?= htmlspecialchars($movie['Year']) ?>)</h1>

        <div class="movie-details">
            <img src="<?= htmlspecialchars($movie['Poster']) ?>" alt="Poster">
            <p><strong>Genre:</strong> <?= htmlspecialchars($movie['Genre']) ?></p>
            <p><strong>Plot:</strong> <?= htmlspecialchars($movie['Plot']) ?></p>

            <!-- Rating form -->
            <form method="POST" action="index.php?action=rate&title=<?= urlencode($movie['Title']) ?>">
                <label for="rating">Rate this movie:</label>
                <select name="rating" id="rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?>/5</option>
                    <?php endfor; ?>
                </select>
                <button type="submit">Submit Rating</button>
            </form>

            <!-- Rating display -->
            <?php if ($average !== null): ?>
                <p><strong>Average Rating:</strong> <?= round($average, 1) ?>/5 (<?= $count ?> votes)</p>
            <?php else: ?>
                <p><strong>Average Rating:</strong> 0/5 (0 votes)</p>
            <?php endif; ?>

            <!-- Gemini review -->
            <form method="POST" action="index.php?action=review&title=<?= urlencode($movie['Title']) ?>">
                <button type="submit">Get AI Review</button>
            </form>

            <h3>AI Review:</h3>
            <p><?= isset($review) ? nl2br(htmlspecialchars($review)) : "Error generating review." ?></p>
        </div>

        <br>
        <a href="index.php">← Back to Search</a>
    </div>
</body>
</html>
