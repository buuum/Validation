<?php

namespace Buuum\Fields;

class FieldObject extends Field
{

    public function __construct($name = false, FieldsCollection $types)
    {
        parent::__construct($name);
        $this->addTypes($types);
    }
}