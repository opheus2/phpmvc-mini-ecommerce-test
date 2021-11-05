<?php

namespace App\Controllers;

use App\Models\User;
use App\core\Request;
use App\core\Controller;
use App\Requests\LoginRequest;

class LoginController extends Controller
{
    public function index()
    {
        //set layout to auth layout before layout rendering
        $this->layout = 'auth';
        return $this->render('login');
    }

    public function login(Request $request)
    {
        //set layout to auth layout before layout rendering
        $this->layout = 'auth';

        //validate login request
        $request = new LoginRequest($request->getBody());
        $request->validate();
        if (!$request->validate()) {
            //re-render the login page with the new errors
            return $this->render('login', [], [
                'errors' => $request->errors
            ]);
        }

        //find user for further validation 
        $user = User::findOne(['email' => $request->validated()['email']]);

        if (empty($user)) {
            return $this->render('login', [], [
                'errors' => [
                    'user' => 'These credentials does not match a record!'
                ]
            ]);
        }

        //use php native password_verify to test the plain text password against the stored hash
        if (!password_verify($request->validated()['password'], $user->password)) {
            return $this->render('login', [], [
                'errors' => [
                    'user' => 'These credentials does not match a record!'
                ]
            ]);
        }

        //sign in the user and if true redirect to protected shop route
        if (app()->login($user)) {
            return $this->redirect('/shop');
        }
    }
}
