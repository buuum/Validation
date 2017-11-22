<?php

namespace Buuum\Fields;

class FieldError
{

    private $name;
    private $errors = [];
    private $alias;
    private $position;
    private $subfields = [];

    public function __construct($name, $alias, $position = false)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->position = $position;
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function addSubfield($fieldError)
    {
        $this->subfields[] = $fieldError;
    }

    public function name()
    {
        return $this->name;
    }

    public function alias()
    {
        return $this->alias;
    }

    public function index()
    {
        return $this->position;
    }

    public function position()
    {
        return $this->position !== false ? $this->position + 1 : '';
    }

    public function subfields()
    {
        return $this->subfields;
    }

    public function errors()
    {
        return $this->errors;
    }

}