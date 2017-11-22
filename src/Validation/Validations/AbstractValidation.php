<?php

namespace Buuum\Validations;


use Buuum\Fields\FieldError;

abstract class AbstractValidation implements Validation
{

    protected $message;

    public function __construct($message = false)
    {
        $this->message = $message;
    }

    public function message()
    {
        return $this->message;
    }

    public function getVars()
    {
        $vars = get_object_vars($this);
        return array_values($vars);
    }

    public function error(FieldError $fieldError, $message)
    {
        if ($this->message()) {
            $message = $this->message();
        }

        $message = str_replace([':attribute', ':fieldname'], [$fieldError->alias(), $fieldError->name()], $message);
        $message = str_replace([':value', ':value2', ':value3', ':value4', ':value5'], $this->getVars(), $message);

        return $message;
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