<?php
session_start();

require_once 'app/core/Database.php';
require_once 'app/controllers/MovieController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/models/Movie.php';
require_once 'app/models/Rating.php';
require_once 'app/models/User.php';


    use App\Controllers\MovieController;
    use App\Controllers\AuthController;

    $action = $_GET['action'] ?? 'search';

    switch ($action) {
        case 'search':
            (new MovieController())->search();
            break;
        case 'details':
            (new MovieController())->details($_GET['title'] ?? '');
            break;
        case 'rate':
            (new MovieController())->rate($_GET['title'] ?? '');
            break;
        case 'review':
            (new MovieController())->review($_GET['title'] ?? '');
            break;
        case 'loginForm':
            (new AuthController())->loginForm();
            break;
        case 'login':
            (new AuthController())->login();
            break;
        case 'logout':
            (new AuthController())->logout();
            break;
        case 'registerForm':
            (new AuthController())->registerForm();
            break;
        case 'register':
            (new AuthController())->register();
            break;
        default:
            echo "404 - Page not found.";
    }
