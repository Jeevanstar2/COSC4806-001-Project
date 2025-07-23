<?php
// app/views/movie/index.php
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Movie</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <p>
            You are browsing as 
            <?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['username']) : 'Guest'; ?> 
            | <a href="index.php?action=logout">Logout</a>
        </p>

        <h1>🎥 Search for a Movie</h1>

        <!-- ✅ FIX: use GET with direct URL -->
        <form method="get" action="index.php">
            <input type="hidden" name="action" value="search">
            <input type="text" name="title" placeholder="Enter movie title..." required>
            <button type="submit">🔍 Search</button>
        </form>
    </div>
</body>
</html>
