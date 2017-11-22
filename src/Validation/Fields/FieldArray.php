<?php

namespace RequestCheck\Fields;

class FieldArray extends Field
{

    public function __construct($name = false, Field $field)
    {
        parent::__construct($name);
        $this->setArray();
        if ($field instanceof FieldObject) {
            $this->addTypes($field->types());
        } elseif ($field instanceof FieldArray) {
            $this->addTypes([$field]);
        } else {
            $this->validations = $field->validations;
            $this->filters = $field->filters;
        }
    }

    public function setValidations($validations)
    {
        $this->validations_array = $validations;
    }
}