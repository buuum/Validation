<?php

namespace Buuum;

use Buuum\Fields\FieldError;
use Buuum\Validations\AbstractValidation;

class RequestResponse
{

    const DEFAULT_MESSAGE = 'The :attribute is invalid';

    private $errors = [];
    private $messages = [];

    public function __construct($messages = [])
    {
        $this->messages = $messages;
    }

    public function addError(FieldError $fieldError)
    {
        $this->errors[] = $fieldError;
    }

    public function parseError(AbstractValidation $validation, FieldError $fieldError): string
    {
        $classname = get_class($validation);
        $message = self::DEFAULT_MESSAGE;
        if (!empty($this->messages[$classname])) {
            $message = $this->messages[$classname];
        }
        $classname = $validation->error($fieldError, $message);
        return $classname;
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