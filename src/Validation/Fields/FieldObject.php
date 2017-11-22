<?php

namespace RequestCheck\Fields;

class FieldObject extends Field
{

    public function __construct($name, FieldsCollection $types)
    {
        parent::__construct($name);
        $this->addTypes($types);
    }
}