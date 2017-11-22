<?php

namespace RequestCheck\Fields;

use RequestCheck\Validations\ValidRequired;

class Field
{
    protected $name;
    protected $filters = [];
    protected $validations = [];
    protected $sub_types = [];
    protected $is_array = false;
    protected $validations_array = [];
    protected $alias;
    protected $errors_class;

    public function __construct($name)
    {
        $this->name = $name;
    }

    protected function setArray()
    {
        $this->is_array = true;
        return $this;
    }

    protected function addTypes($types)
    {
        $this->sub_types = $types;
        return $this;
    }

    public function filter($data): array
    {
        if (isset($data[$this->name]) && (!empty($data[$this->name]) || is_numeric($data[$this->name]))) {
            if ($this->is_array) {
                if (!empty($this->sub_types)) {
                    foreach ($data[$this->name] as $k => $value) {
                        foreach ($this->sub_types as $type) {
                            $data[$this->name][$k] = $type->filter($data[$this->name][$k]);
                        }
                    }
                } else {
                    foreach ($data[$this->name] as $k => $value) {
                        foreach ($this->filters as $filter) {
                            $data[$this->name][$k] = $filter->filter($value);
                        }
                    }
                }
            } elseif (!empty($this->sub_types)) {
                foreach ($this->sub_types as $type) {
                    $data[$this->name] = $type->filter($data[$this->name]);
                }
            } else {
                foreach ($this->filters as $filter) {
                    $data[$this->name] = $filter->filter($data[$this->name]);
                }
            }
        }

        return $data;
    }

    public function validate($data): bool
    {
        $this->errors_class = new FieldError($this->name, $this->alias());
        $errors = false;

        if (isset($data[$this->name]) && (!empty($data[$this->name]) || is_numeric($data[$this->name]))) {
            if ($this->is_array) {

                if (!empty($this->validations_array)) {
                    foreach ($this->validations_array as $validation) {
                        if (!$validation->validate($data[$this->name])) {
                            $this->errors_class->addError($validation);
                            $errors = true;
                        }
                    }
                }

                if (!empty($this->sub_types)) {

                    foreach ($data[$this->name] as $k => $value) {
                        $error = new FieldError($this->name, $this->alias(), $k);
                        foreach ($this->sub_types as $type) {
                            if (!$type->validate($data[$this->name][$k])) {
                                $error->addSubfield($type->getErrors());
                                $errors = true;
                            }
                        }
                        $this->errors_class->addSubfield($error);
                    }

                } else {
                    foreach ($data[$this->name] as $k => $value) {
                        $error = new FieldError($this->name, $this->alias(), $k);
                        foreach ($this->validations as $validation) {
                            if (!$validation->validate($value)) {
                                $error->addError($validation);
                                $errors = true;
                            }
                        }
                        $this->errors_class->addSubfield($error);
                    }
                }

            } elseif (!empty($this->sub_types)) {
                foreach ($this->sub_types as $type) {
                    if (!$type->validate($data[$this->name])) {
                        $this->errors_class->addSubfield($type->getErrors());
                        $errors = true;
                    }
                }
            } else {
                foreach ($this->validations as $validation) {
                    if (!$validation->validate($data[$this->name])) {
                        $this->errors_class->addError($validation);
                        $errors = true;
                    }
                }
            }

        } else {
            foreach ($this->validations as $validation) {
                if ($validation instanceof ValidRequired) {
                    $this->errors_class->addError($validation);
                    $errors = true;
                }
            }
        }

        return !$errors;
    }

    protected function types()
    {
        return $this->sub_types;
    }

    public function setFilters($filters)
    {
        $this->filters = $filters;
        return $this;
    }

    public function setValidations($validations)
    {
        $this->validations = $validations;
        return $this;
    }

    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    protected function alias()
    {
        return $this->alias ? $this->alias : $this->name;
    }

    public function getErrors()
    {
        return $this->errors_class;
    }
}