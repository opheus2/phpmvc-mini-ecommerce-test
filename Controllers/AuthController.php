<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Request;
use App\core\Response;
use App\Core\Controller;
use App\Core\Application;
use App\Models\LoginForm;
use App\Core\Middlewares\AuthMiddleware;
use App\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->registerMiddleWare(new AuthMiddleware(['profile']));
    }

    public function login(LoginRequest $request)
    {
        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
                Application::$app->session->setFlash('success', 'Login successful');
                $this->redirect('/');
            }
        }

        $this->layout = 'auth';
        return $this->render('login');
    }

    public function register(Request $request)
    {
        $user = new User;
        $this->layout = 'auth';

        if ($request->isPost()) {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlash('success', 'Registration successful');
                $this->redirect('/');
            }

            return $this->render('register', [
                'model' => $user
            ]);
        }

        return $this->render('register', [
            'model' => $user
        ]);
    }

    public function logout(Request $request)
    {
        Application::$app->logout();

        $this->redirect('/');
    }

    public function profile()
    {
        return $this->render('profile');
    }
}
