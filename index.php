<?php
ob_start(); 
session_start();
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/' . $class . '.php';
    if (file_exists($file)) 
    {
        require $file;
    }
});
use app\controllers\AuthController;
use app\controllers\MovieController;
$action = $_GET['action'] ?? '';
switch ($action) 
{
    case 'login':
        (new AuthController())->login();
        break;
    case 'register':
        (new AuthController())->register();
        break;
    case 'logout':
        (new AuthController())->logout();
        break;
    case 'guest':
        $_SESSION['guest'] = true;
        header("Location: index.php?action=search");
        exit;
    case 'search':
        if (isset($_SESSION['user']) || isset($_SESSION['guest'])) 
        {
            $movieController = new MovieController();
            if (isset($_GET['title']) && !empty($_GET['title'])) 
            {
                $movieController->search();
            } 
            else 
            {
                require __DIR__ . '/app/views/movie/search.php';
            }
        } 
        else 
        {
            header("Location: index.php");
            exit;
        }
        break;
    case 'rate':
        if (isset($_SESSION['user']) || isset($_SESSION['guest'])) 
        {
            (new MovieController())->rate();
        } 
        else 
        {
            header("Location: index.php");
            exit;
        }
        break;
    case 'review':
        if (isset($_SESSION['user']) || isset($_SESSION['guest'])) 
        {
            (new MovieController())->review();
        } 
        else 
        {
            header("Location: index.php");
            exit;
        }
        break;
    default:
        if (isset($_SESSION['user']) || isset($_SESSION['guest'])) 
        {
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
            <header class="navbar">
                <div class="logo"><a href="index.php" style="color: inherit; text-decoration: none;">🎬 CineReview</a></div>
                <nav>
                    <ul>
                        <li><a href="index.php?action=search">Search</a></li>
                        <li><a href="index.php?action=login">Login</a></li>
                        <li><a href="index.php?action=register">Register</a></li>
                    </ul>
                </nav>
            </header>
            <div class="container centered">
                <h1>🎬 Welcome to Movie Reviewer</h1>
                <p>Choose an option to continue:</p>
                <div style="display:flex; flex-wrap:wrap; gap:20px; justify-content:center;">
                    <a href="index.php?action=login"><button>🔐 Login</button></a>
                    <a href="index.php?action=register"><button>📝 Register</button></a>
                    <form action="index.php?action=guest" method="post" style="display:inline;">
                        <button type="submit">🎭 Continue as Guest</button>
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
        break;
}
ob_end_flush(); 
?>