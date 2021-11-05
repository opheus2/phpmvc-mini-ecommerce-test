<?php

namespace App\Core;

use App\Rules\UniqueRule;
use Rakit\Validation\Validator;

abstract class FormRequest extends Request
{

    public Validator $validator;
    public array $formData;
    public array $errors;
    public $validation;

    /**
     * Class constructor.
     */
    public function __construct(array $formData)
    {
        $this->validator = new Validator();
        $this->validator->addValidator('unique', new UniqueRule());
        $this->formData = $formData;
    }

    abstract public function rules(): array;
    
    /**
     * Validate all input against rules and return bool
     *
     * @return bool
     */
    public function validate(): bool
    {
        $this->validation = $this->validator->make($this->formData, $this->rules());
        $this->validation->validate();

        if ($this->validation->fails()) 
        {
            // handling errors
            $this->errors = $this->validation->errors()->all();
            return false;
        }
        
        return true;
    }

        
    /**
     * Return validated data only
     *
     * @return array
     */
    public function validated(): array
    {
        return $this->validation->getValidData();
    }
}
