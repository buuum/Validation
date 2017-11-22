<?php

namespace RequestCheck\Validations;

class ValidUrl extends AbstractValidation
{

    public function validate($value)
    {
        if (empty($value)) {
            return false;
        }

        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        return true;
    }
}