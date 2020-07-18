<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ActiveModelRule implements Rule
{
    private $model;
    private $value;
    private $attribute;
    private $model_name;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model=$model;
        $arrayName=explode("\\",$model);
        $this->model_name = strtolower(end($arrayName));
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $this->value=$value;
        $this->attribute=$attribute;
        $instancia=$this->model::find($this->value);

        if ($instancia!=null) {
            if($instancia->status=='inactive')
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'INACTIVE # '. $this->attribute.' # The '. $this->model_name .' has status inactive.';
    }
}
