<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
    <div class="auth-container">
        <h2>Register</h2>
        <?php if (!empty($error)): ?>
            <p style="color: red;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>
        <form method="POST" action="index.php?action=register">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <label>Confirm Password:</label>
            <input type="password" name="confirm" required>
            <button type="submit">Create Account</button>
        </form>
        <p>Already have an account? <a href="index.php?action=loginForm">Login here</a></p>
    </div>
</body>
</html>