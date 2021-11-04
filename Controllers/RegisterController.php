<?php

namespace App\Controllers;

use App\Core\Application;
use App\core\Controller;
use App\core\Request;
use App\Models\User;
use App\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function index()
    {
        $this->layout = 'auth';
        return $this->render('register');
    }
    
    public function register(Request $request)
    {
        $this->layout = 'auth';
        $request = new RegisterRequest($request->getBody());
        $request->validate();
        if (!$request->validate()) {
            return $this->render('register', [], [
                'errors' => $request->errors
            ]);
        }

        $data = $request->validated();
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        unset($data['confirm_password']);

        try {
            $user = (new User)->save($data);
            if ($user) {
                Application::$app->session->setFlash('success', 'Registration successful. Please login');
                return $this->redirect('/login');
            }
        } catch (\Exception $e) {
            return $this->render('register', [], [
                'errors' => ['registration' => $e->getMessage()]
            ]);
        }
    }
}
