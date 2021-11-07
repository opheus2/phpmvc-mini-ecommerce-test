<?php

use Dotenv\Dotenv;
use orpheusohms\phpmvc\Application;
use App\Controllers\CartController;
use App\Controllers\CheckoutController;
use App\Controllers\ShopController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Controllers\ProductController;
use App\Controllers\RegisterController;
use App\Controllers\UserController;

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

$app->router->get('/user', [UserController::class, '__invoke']);

/** End Auth Routes */


/** Begin Shop Routes */

$app->router->get('/', [ShopController::class, '__invoke']);
$app->router->get('/shop', [ShopController::class, '__invoke']);
$app->router->post('/shop/checkout', [CheckoutController::class, '__invoke']);

$app->router->get('/products', [ProductController::class, 'index']);
$app->router->post('/products/rate', [ProductController::class, 'rateProduct']);

$app->router->get('/carts', [CartController::class, 'index']);
$app->router->get('/carts/add', [CartController::class, 'addProductToCart']);
$app->router->get('/carts/remove', [CartController::class, 'removeProductFromCart']);
$app->router->get('/carts/update', [CartController::class, 'updateProductQuantity']);

/** End Shop Routes */


$app->run();
