<?php

namespace Buuum\Validations;


class ValidEmail extends AbstractValidation
{

    public function validate($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}