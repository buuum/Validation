<?php

namespace RequestCheck\Validations;

class ValidObjectDate extends AbstractValidation
{

    public $fields;
    private $format;

    public function __construct($fields = [], $format, $message = false)
    {
        $this->fields = $fields;
        $this->format = $format;
        parent::__construct($message);
    }

    public function validate($value)
    {
        $date = '';
        foreach ($this->fields as $field) {
            if (!isset($value[$field->name()])) {
                return false;
            }
            $date .= $value[$field->name()];
        }

        $d = \DateTime::createFromFormat($this->format, $date);
        return $d && ($d->format($this->format) === $date);
    }

    public function getVars()
    {
        return [
            'format' => $this->format
        ];
    }
}