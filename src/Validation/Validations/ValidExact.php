<?php

namespace Buuum\Validations;


class ValidExact extends AbstractValidation
{

    public $value;

    public function __construct($value, $message = false)
    {
        $this->value = $value;
        parent::__construct($message);
    }

    public function validate($value)
    {
        return $this->getSize($value) == $this->value;
    }
}