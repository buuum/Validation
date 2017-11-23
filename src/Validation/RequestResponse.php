<?php

namespace RequestCheck;

class RequestResponse
{
    private $errors = [];
    private $messages = [];

    public function __construct($messages = [])
    {
        $this->messages = $messages;
    }

    public function addError($fieldError)
    {
        $this->errors[] = $fieldError;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

}