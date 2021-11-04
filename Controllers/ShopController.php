<?php 

namespace App\Controllers;

use App\core\Controller;
use App\Middlewares\AuthMiddleware;

class ShopController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->registerMiddleWare(new AuthMiddleware());
    }

    public function __invoke()
    {
        return 'blaad';
    }
}
