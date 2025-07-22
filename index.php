<?php
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/Movie.php';
require_once __DIR__ . '/app/models/Rating.php';
require_once __DIR__ . '/app/controllers/MovieController.php';

use App\Controllers\MovieController;

$action = $_GET['action'] ?? 'index';

$controller = new \App\Controllers\MovieController();

switch ($action) {
    case 'search':
        $controller->search();
        break;
    case 'rate':
        $controller->rate();
        break;
    case 'review':
        $controller->review();
        break;
    default:
        $controller->index();
        break;
}
