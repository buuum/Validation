<?php

namespace Buuum;

class RequestErrors
{

    private $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getKeyErrors()
    {
        return array_keys($this->errors);
    }

}