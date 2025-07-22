<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <h2>Register</h2>
    
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?action=register">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirm Password:</label><br>
        <input type="password" name="confirm" required><br><br>

        <button type="submit">Create Account</button>
    </form>

    <p>Already have an account? <a href="index.php?action=loginForm">Login here</a></p>
</body>
</html>
