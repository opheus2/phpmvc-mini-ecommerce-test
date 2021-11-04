<?php

use Dotenv\Dotenv;
use App\Core\Application;
use App\Controllers\ShopController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Controllers\RegisterController;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

if ($_ENV['APP'] != 'production')
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$config = [
    'userClass' => \App\Models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);

/** Begin Auth Routes */

$app->router->get('/login', [LoginController::class, 'index']);
$app->router->post('/login', [LoginController::class, 'login']);

$app->router->post('/logout', [LogoutController::class, '__invoke']);

$app->router->get('/register', [RegisterController::class, 'index']);
$app->router->post('/register', [RegisterController::class, 'register']);

/** End Auth Routes */


/** Begin Shop Routes */
$app->router->get('/shop', [ShopController::class, '__invoke']);

$app->router->get('/cart', [CartController::class, '__invoke']);

/** End Shop Routes */


$app->run();
