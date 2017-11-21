<?php

namespace Buuum\Validations;


abstract class AbstractValidation implements Validation
{

    public function getError()
    {
        return static::class;
    }

}