<?php

namespace RequestCheck\Validations;


class ValidRequired extends AbstractValidation
{

    public function validate($value)
    {
        if (empty($value)) {
            return false;
        }

        return true;
    }
}