<?php 

namespace App\Controllers;

use App\core\Request;
use App\core\Controller;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        app()->logout();
        app()->session->setFlash('success', 'Logged out successfully!');
        $this->redirect('/login');
    }
}
