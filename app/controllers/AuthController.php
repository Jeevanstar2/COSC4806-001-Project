<?php
namespace app\controllers;

use app\models\User;

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: index.php');
                exit;
            } else {
                $error = "❌ Invalid credentials.";
            }
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($username && $password) {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $success = User::create($username, $hashed);

                if ($success) {
                    header('Location: index.php?action=login');
                    exit;
                } else {
                    $error = "⚠️ Username already exists.";
                }
            } else {
                $error = "⚠️ Please fill out all fields.";
            }
        }

        require __DIR__ . '/../views/auth/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
