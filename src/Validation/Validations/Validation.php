<?php

namespace Buuum\Validations;


interface Validation
{
    public function validate($value);
    public function getError();
}