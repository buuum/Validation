<?php

namespace RequestCheck\Validations;


class ValidDate extends AbstractValidation
{

    private $format;

    public function __construct($format, $message = false)
    {
        $this->format = $format;
        parent::__construct($message);
    }

    public function validate($value)
    {
        $d = \DateTime::createFromFormat($this->format, $value);
        return $d && ($d->format($this->format) === $value);
    }

    public function getVars()
    {
        return [
            'format' => $this->format
        ];
    }
}