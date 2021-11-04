<?php

namespace App\Core;

use Rakit\Validation\Validator;

abstract class FormRequest extends Request
{

    public Validator $validator;
    public array $formData;
    public array $errors;

    /**
     * Class constructor.
     */
    public function __construct(array $formData)
    {
        $this->validator = new Validator();
        $this->formData = $formData;
    }

    abstract public function rules(): array;

    public function validate()
    {
        $validation = $this->validator->make($this->formData, $this->rules());
        $validation->validate();

        if ($validation->fails()) 
        {
            // handling errors
            $this->errors = $validation->errors()->all();
            return false;
        }
        
        return true;
    }
}
