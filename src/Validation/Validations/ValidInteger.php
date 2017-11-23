<?php

namespace RequestCheck\Validations;


class ValidInteger extends AbstractValidation
{

    public function validate($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            return false;
        }
        return true;
    }

}