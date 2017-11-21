<?php

namespace Buuum\Validations;


class ValidExact extends AbstractValidation
{

    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function validate($value)
    {
        return $this->getSize($value) == $this->value;
    }

    public function getError()
    {
        return self::class . ":{$this->value}";
    }

    protected function getSize($value)
    {
        if (is_numeric($value)) {
            return $value;
        } elseif (is_array($value)) {
            return count($value);
        } else {
            if (function_exists('mb_strlen')) {
                return mb_strlen($value);
            } else {
                return strlen($value);
            }
        }
    }
}