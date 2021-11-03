<?php

namespace App\Core\Form;

use App\core\Model;

abstract class BaseField
{
    public Model $model;
    public string $attribute;
    public string $label;

    /**
     * __construct
     *
     * @param  mixed $model
     * @param  mixed $attribute
     * @return void
     */
    public function __construct(Model $model, string $attribute, string $label = '')
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->label = $label;
    }

    abstract public function renderInput(): string;


    public function __toString()
    {
        return sprintf(
            '<div class="mb-3">
                <label class="form-label">%s</label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>',
            $this->label,
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}
