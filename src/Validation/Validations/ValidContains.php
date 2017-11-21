<?php

namespace Buuum\Validations;


class ValidContains extends AbstractValidation
{

    private $words;

    public function __construct($words)
    {
        $this->words = $words;
    }

    public function validate($value)
    {
        $params = array_map(function ($element) {
            return trim(strtolower($element));
        }, $this->words);

        $val = trim(strtolower($value));

        if (!in_array($val, $params)) {
            return false;
        }

        return true;
    }

    public function getError()
    {
        $words = implode(',', $this->words);
        return self::class . ":$words";
    }
}