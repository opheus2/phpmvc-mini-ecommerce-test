<?php 

namespace App\Controllers;

use orpheusohms\phpmvc\Controller;

class LogoutController extends Controller
{    
    /**
     * Remove session and redirect to login
     *
     * @return mixed
     */
    public function __invoke()
    {
        app()->logout();
        
        //show success message on auth via session flash
        app()->session->setFlash('success', 'Logged out successfully!');
        return $this->redirect('/login');
    }
}
