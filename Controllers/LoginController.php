<?php

namespace App\Controllers;

use App\Core\Application;
use App\Models\User;
use App\core\Request;
use App\core\Controller;
use App\Requests\LoginRequest;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $this->layout = 'auth';
        return $this->render('login');
    }

    public function login(Request $request)
    {
        $this->layout = 'auth';
        $request = new LoginRequest($request->getBody());
        $request->validate();
        if (!$request->validate()) {
            return $this->render('login', [], [
                'errors' => $request->errors
            ]);
        }

        $user = User::findOne(['email' => $request->validated()['email']]);

        if (empty($user)) {
            return $this->render('login', [], [
                'errors' => [
                    'user' => 'These credentials does not match a record!'
                ]
            ]);
        }

        if (!password_verify($request->validated()['password'], $user->password)) {
            return $this->render('login', [], [
                'errors' => [
                    'user' => 'These credentials does not match a record!'
                ]
            ]);
        }

        if (Application::$app->login($user)) {
            return $this->render('shop');
        }
    }
}
