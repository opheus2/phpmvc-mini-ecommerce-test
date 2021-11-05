<?php

namespace App\Requests;

use App\Core\FormRequest;

class LoginRequest extends FormRequest
{
    public function __construct(array $formData)
    {
        parent::__construct($formData);
    }

    public function rules(): array
    {
        return [
            'email'                 => 'required|email',
            'password'              => 'required|min:6'
        ];
    }
}
