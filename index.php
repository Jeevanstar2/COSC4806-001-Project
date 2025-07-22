
<?php
session_start();

// Include autoloader or required files
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Controllers\AuthController;
use App\Controllers\MovieController;

$action = $_GET['action'] ?? '';

// Handle different actions
switch ($action) {
    case 'login':
        $authController = new AuthController();
        $authController->login();
        break;
        
    case 'register':
        $authController = new AuthController();
        $authController->register();
        break;
        
    case 'logout':
        $authController = new AuthController();
        $authController->logout();
        break;
        
    case 'guest':
        $_SESSION['guest'] = true;
        header("Location: index.php?action=search");
        exit;
        
    case 'search':
        // Check if user is logged in or is a guest
        if (isset($_SESSION['user']) || isset($_SESSION['guest'])) {
            $movieController = new MovieController();
            if (isset($_GET['title']) && !empty($_GET['title'])) {
                $movieController->search();
            } else {
                // Show search form
                require __DIR__ . '/app/views/movie/search.php';
            }
        } else {
            header("Location: index.php");
            exit;
        }
        break;
        
    case 'rate':
        if (isset($_SESSION['user']) || isset($_SESSION['guest'])) {
            $movieController = new MovieController();
            $movieController->rate();
        } else {
            header("Location: index.php");
            exit;
        }
        break;
        
    case 'review':
        if (isset($_SESSION['user']) || isset($_SESSION['guest'])) {
            $movieController = new MovieController();
            $movieController->review();
        } else {
            header("Location: index.php");
            exit;
        }
        break;
        
    default:
        // Show welcome page only if not logged in
        if (isset($_SESSION['user']) || isset($_SESSION['guest'])) {
            header("Location: index.php?action=search");
            exit;
        }
        
        // Show welcome page
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
        <?php
        break;
}
?>
