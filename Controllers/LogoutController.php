<?php 

namespace App\Controllers;

use App\core\Request;
use App\core\Controller;
use App\core\Response;

class LogoutController extends Controller
{    
    /**
     * Remove session and redirect to login
     *
     * @return Response
     */
    public function __invoke(): Response
    {
        app()->logout();
        
        //show success message on auth via session flash
        app()->session->setFlash('success', 'Logged out successfully!');
        return $this->redirect('/login');
    }
}
