<!DOCTYPE html>
<html>
<head>
    <title>Movie Search</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
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
    <h1>🎬 Movie Search</h1>
    <form method="GET" action="index.php">
        <input type="hidden" name="action" value="search">
        <label>Search for a movie:</label><br>
        <input type="text" name="title" placeholder="Enter movie title..." required>
        <button type="submit">Search</button>
    </form>
</body>
</html>