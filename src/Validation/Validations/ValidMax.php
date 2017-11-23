<?php

namespace RequestCheck\Validations;


class ValidMax extends AbstractValidation
{

    public $value;

    public function __construct($value, $message = false)
    {
        $this->value = $value;
        parent::__construct($message);
    }

    public function validate($value)
    {
        return $this->getSize($value) <= $this->value;
    }

    public function getVars()
    {
        return [
            'value' => $this->value
        ];
    }

}