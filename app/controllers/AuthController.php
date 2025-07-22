<?php
namespace App\Controllers;

use App\Models\User;

class AuthController {
    public function loginForm() {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username']
            ];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid username or password.";
            require __DIR__ . '/../views/auth/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit;
    }

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

        $existing = User::findByUsername($username);
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
}
