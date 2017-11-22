<?php

namespace Buuum;

use Buuum\Fields\FieldsCollection;

class RequestCheck
{
    private $data;
    private $types;
    private $filter_data = [];
    private $errors_object;

    public function __construct(array $data, FieldsCollection $types, $messages = [])
    {
        $this->data = $data;
        $this->types = $types;
        $this->errors_object = new RequestResponse($messages);
    }

    public function filter(): array
    {
        $this->filter_data = $this->data;
        foreach ($this->types as $type) {
            $this->filter_data = $type->filter($this->filter_data);
        }

        return $this->filter_data;
    }

    public function validate(): RequestResponse
    {
        if (empty($this->filter_data)) {
            $this->filter_data = $this->data;
        }
        foreach ($this->types as $type) {
            if (!$type->validate($this->filter_data)) {
                $this->errors_object->addError($type->getErrors());
            }
        }

        return $this->errors_object;
    }

}