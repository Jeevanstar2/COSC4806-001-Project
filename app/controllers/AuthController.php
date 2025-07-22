public function registerForm() {
    require __DIR__ . '/../views/auth/register.php';
}

public function register() {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
        require __DIR__ . '/../views/auth/register.php';
        return;
    }

    $existing = \App\Models\User::findByUsername($username);
    if ($existing) {
        $error = "Username already taken.";
        require __DIR__ . '/../views/auth/register.php';
        return;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $db = \App\Core\Database::connect();
    $stmt = $db->prepare("INSERT INTO people (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hash]);

    $_SESSION['user'] = [
        'id' => $db->lastInsertId(),
        'username' => $username
    ];

    header("Location: index.php");
    exit;
}
