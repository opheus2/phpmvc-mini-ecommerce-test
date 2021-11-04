<?php 

namespace App\Controllers;

use App\core\Request;
use App\core\Controller;
use App\Core\Application;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        Application::$app->logout();
        Application::$app->session->setFlash('success', 'Logged out successfully!');
        $this->redirect('/login');
    }
}
