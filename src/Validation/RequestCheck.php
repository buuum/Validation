<?php

namespace RequestCheck;

use RequestCheck\Fields\InputCollection;

class RequestCheck
{
    private $data;

    private $types;
    private $filter_data = [];
    private $errors_object;

    public function __construct(array $data, InputCollection $types)
    {
        $this->data = $data;
        $this->filter_data = $data;
        $this->types = $types;
        $this->errors_object = new RequestResponse();
    }

    public function filter(): array
    {
        foreach ($this->types as $field) {
            if (isset($this->filter_data[$field->name()]) && (!empty($this->filter_data[$field->name()]) || is_numeric($this->filter_data[$field->name()]))) {
                $this->filter_data[$field->name()] = $field->filter($this->filter_data[$field->name()]);
            }
        }

        return $this->filter_data;
    }

    public function validate(): RequestResponse
    {
        foreach ($this->types as $k => $field) {
            $dataitem = isset($this->filter_data[$field->name()]) ? $this->filter_data[$field->name()] : null;
            if (!$field->validate($dataitem)) {
                $this->errors_object->addError($field->getErrors());
            }
        }

        return $this->errors_object;
    }

}