<?php
session_start();

if (isset($_SESSION['user']) || isset($_SESSION['guest'])) {
    header("Location: index.php?action=search");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>🎬 Welcome to Movie Reviewer</h1>
        <p>Choose an option to continue:</p>

        <a href="index.php?action=login"><button>🔐 Login</button></a>
        <a href="index.php?action=register"><button>📝 Register</button></a>

        <form action="index.php?action=guest" method="post" style="display:inline;">
            <button type="submit">🎭 Continue as Guest</button>
        </form>
    </div>
</body>
</html>
