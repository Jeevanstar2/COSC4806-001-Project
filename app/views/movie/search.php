<!DOCTYPE html>
<html>
<head>
    <title>Movie Search</title>
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
    <div class="container centered">
        <h1>🎬 Movie Search</h1>
        <form method="GET" action="index.php">
            <input type="hidden" name="action" value="search">
            <label>Search for a movie:</label>
            <input type="text" name="title" placeholder="Enter movie title..." required>
            <button type="submit">Search</button>
        </form>
    </div>
</body>
</html>