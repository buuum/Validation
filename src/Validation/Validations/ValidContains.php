<?php

namespace RequestCheck\Validations;


class ValidContains extends AbstractValidation
{

    public $words;

    public function __construct(array $words, $message = false)
    {
        $this->words = $words;
        parent::__construct($message);
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

    public function getVars()
    {
        $words = implode(', ', $this->words);
        return [
            'words' => $words
        ];
    }
}