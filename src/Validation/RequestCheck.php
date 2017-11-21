<?php

namespace Buuum;

use Buuum\Fields\FieldsCollection;

class RequestCheck
{
    private $data;
    private $types;
    private $errors = [];
    private $filter_data = [];
    private $messages;

    public function __construct(array $data, FieldsCollection $types)
    {
        $this->data = $data;
        $this->types = $types;
        $this->messages = include_once __DIR__ . '/messages.php';
    }

    public function filter()
    {
        $this->filter_data = $this->data;
        foreach ($this->types as $type) {
            $this->filter_data = $type->filter($this->filter_data);
        }

        return $this->filter_data;
    }

    public function validate()
    {
        foreach ($this->types as $type) {
            if (!$type->validate($this->filter_data)) {
                $this->errors += $type->getErrors();
            }
        }

        return $this->errors;
    }

    public function getErrors()
    {
        array_walk_recursive($this->errors, [$this, 'parseError']);
        return $this->errors;
    }

    private function parseError(&$item, $key)
    {
        if (is_string($item)) {
            if ($message = $this->parseErrorString($item)) {
                $item = $message;
            }
        }
    }

    private function parseErrorString($string)
    {
        $parts = explode(':', $string);
        if (count($parts) < 2 || !in_array($parts[0], array_keys($this->messages))) {
            return false;
        }

        return $this->setMessage($parts);
    }

    private function setMEssage($parts)
    {
        $alias = array_pop($parts);
        $fieldname = array_pop($parts);
        $error = array_shift($parts);

        $message = str_replace([':attribute', ':fieldname'], [$alias, $fieldname], $this->messages[$error]);

        $message = str_replace([':value', ':value2', ':value3', ':value4', ':value5'], $parts, $message);

        return $message;
    }

}