<?php

namespace RequestCheck\Validations;

class ValidEquals extends AbstractValidation
{
    public $fields = [];

    public function __construct($fields = [], $message = false)
    {
        $this->fields = $fields;
        parent::__construct($message);
    }

    public function validate($value)
    {
        $valid = true;
        $value_to_check = false;
        foreach ($this->fields as $field) {
            if (!isset($value[$field->name()])) {
                return false;
            }
            if (!$value_to_check) {
                $value_to_check = $value[$field->name()];
            } elseif ($value_to_check != $value[$field->name()]) {
                return false;
            }
        }

        return $valid;
    }

    public function getVars()
    {
        return [
            'fields' => ''
        ];
    }
}