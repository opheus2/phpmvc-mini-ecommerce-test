<?php

namespace App\Controllers;

use App\core\Controller;
use App\core\Request;
use App\Core\View;
use App\Models\User;
use App\Requests\RegisterRequest;

class RegisterController extends Controller
{
    
    /**
     * Show registration page
     *
     * @return mixed
     */
    public function index()
    {
        $this->layout = 'auth';
        return $this->render('register');
    }

    /**
     * Register the guest
     *
     * @param  mixed $request
     * @return mixed 
     */
    public function register(Request $request): mixed 
    {
        //set layout to auth layout before layout rendering
        $this->layout = 'auth';

        //validate request using form request
        $request = new RegisterRequest($request->getBody());
        $request->validate();
        if (!$request->validate()) {
            //re-render the register page with the new errors
            return $this->render('register', [], [
                'errors' => $request->errors
            ]);
        }

        //get only validated data
        $data = $request->validated();

        //convert plain text password to standard bcrypt pass
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        //remove confirm password key has it isn't needed anymore
        unset($data['confirm_password']);

        try {

            //insert into the users table with guest data
            $user = (new User)->save($data);
            if ($user) {

                //show a success message to new user via session flash
                app()->session->setFlash('success', 'Registration successful. Please login');
                return $this->redirect('/login');
            }
        } catch (\Exception $e) {
            return $this->render('register', [], [
                'errors' => ['registration' => $e->getMessage()]
            ]);
        }
    }
}
