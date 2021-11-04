<?php

use App\Core\Application;
use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'userClass' => \App\Models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(__DIR__, $config);

if (!function_exists('seedDb')) {
    function seedDb()
    {
        global $app;
        $app->db->log('Seeding started');
        try {
            seedCurrenciesTable();
            seedProductsTable();
            seedUsersTable();
            $app->db->log('Seeding completed');
        } catch (\Exception $e) {
            $app->db->log('An error has occurred!');
            $app->db->log($e->getMessage());
        }
    }
}

if (!function_exists('seedCurrenciesTable')) {
    function seedCurrenciesTable()
    {
        global $app;
        $app->db->log('Seeding currencies table');
        $currencies = array(['name' => 'United States Dollars', 'symbol' => '$']);
        foreach ($currencies as $currency) {
            $app->db->insert($currency, 'currencies');
        }
        $app->db->log('Seeded currencies table');
    }
}


if (!function_exists('seedProductsTable')) {
    function seedProductsTable()
    {
        'apple is 0.3$, a beer is 2$, water is 1$ each bottle and cheese is 3.74$ each kg';
        global $app;
        $app->db->log('Seeding products table');
        $products = [
            [
                'name' => 'Apple',
                'amount' => 0.3,
                "category" => 'foods',
                "image" => 'apple.jpg',
                'description' => "Idared is an apple variety that was first developed in Idaho. It's a cross between the Jonathan and Wagener breeds. The apples are medium-sized with a bright red and green-red color. The flesh is juicy, crisp, and firm, while the flavors are sweet, tart, aromatic, and refreshing.",
                "weight" => "0.0002kg",
                "currency_id" => 1
            ],
            [
                'name' => 'Beer',
                'amount' => 2,
                "category" => 'drinks',
                "image" => 'beer.jpg',
                'description' => "Kingfisher - India, The king of beers in India accounts for one out of every three bottles sold in the country. Kingfisher also hosts The Great Indian October Fest every year in Bangalore, which offers beer, food, music, a flea market and even an auto show. Since its inception in 1978 it has broadened its range to seven variants, each one equally as pleasing whether it's accompanying a korma or a vindaloo.",
                "weight" => "1.015kg",
                "currency_id" => 1
            ],
            [
                'name' => 'Water',
                'amount' => 1,
                "category" => 'drinks',
                "image" => 'water.jpg',
                'description' => "One of the UK's most prestigious bottled waters, Hildon Natural Mineral Water is served at the House of Commons and the Royal Opera House and is rumored to be the water of choice at Buckingham Palace. Hildon begins as rainfall, which percolates through the chalk hills of the Hampshire countryside. ",
                "weight" => "0.0005kg",
                "currency_id" => 1
            ],
            [
                'name' => 'Cheese',
                'amount' => 3.74,
                "category" => 'foods',
                "image" => 'cheese.jpg',
                'description' => "Mozzarella cheese",
                "weight" => "1kg",
                "currency_id" => 1
            ]
        ];

        foreach ($products as $product) {
            $app->db->insert($product, 'products');
        }
        $app->db->log('Seeded products table');
    }
}


if (!function_exists('seedUsersTable')) {
    function seedUsersTable()
    {
        global $app;
        $app->db->log('Seeding users table');
        $users = array([
            'first_name' => 'Demo',
            'last_name' => 'User',
            'email' => 'demo@demo.com',
            'password' => password_hash('123456', PASSWORD_BCRYPT),
        ]);
        foreach ($users as $user) {
            $app->db->insert($user, 'users');
        }
        $app->db->log('Seeded users table');
    }
}

seedDb();
