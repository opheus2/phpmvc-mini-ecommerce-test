<?php

namespace App\Requests;

use App\Core\FormRequest;
use Rakit\Validation\Validator;

class LoginRequest extends FormRequest
{
    public function __construct(array $formData)
    {
        parent::__construct($formData);
    }

    public function rules(): array
    {
        return [
            // 'name'                  => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|min:6',
            // 'confirm_password'      => 'required|same:password',
        ];
    }
}
