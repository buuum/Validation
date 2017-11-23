<?php

namespace RequestCheck\Fields;

class InputError
{

    private $input;
    private $position;
    private $errors = [];
    private $subfields = [];

    public function __construct(AbstractInput $input)
    {
        $this->input = $input;
        $this->position = $input->position();
    }

    public function position()
    {
        return $this->position !== false ? $this->position + 1 : '';
    }

    public function alias()
    {
        return $this->input->alias();
    }

    public function name()
    {
        return $this->input->name();
    }

    public function input()
    {
        return $this->input;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function addSubfield($fieldError)
    {
        $this->subfields[] = $fieldError;
    }

    public function subfields()
    {
        return $this->subfields;
    }

    public function isValid()
    {
        return empty($this->errors) && empty($this->subfields());
    }

}