<?php

namespace App\Requests;

use App\Core\FormRequest;

class RegisterRequest extends FormRequest
{
    public function __construct(array $formData)
    {
        parent::__construct($formData);
    }

    public function rules(): array
    {
        return [
            'first_name'            => 'required|alpha',
            'last_name'             => 'required|alpha',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6',
            'confirm_password'      => 'required|same:password',
        ];
    }
}
