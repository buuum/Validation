<?php

namespace Buuum\Fields;

use Buuum\Validations\ValidRequired;

class Field
{
    protected $name;
    protected $filters = [];
    protected $validations = [];
    protected $errors = [];
    protected $sub_types = [];
    protected $is_array = false;
    protected $validations_array = [];
    protected $alias;

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

    public function filter($data)
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

    public function validate($data)
    {
        $this->errors = [];

        if (isset($data[$this->name]) && (!empty($data[$this->name]) || is_numeric($data[$this->name]))) {
            if ($this->is_array) {

                if (!empty($this->validations_array)) {
                    foreach ($this->validations_array as $validation) {
                        if (!$validation->validate($data[$this->name])) {
                            $this->errors[$this->name]['_field_name'] = $this->name;
                            $this->errors[$this->name]['_alias'] = $this->alias();
                            $this->errors[$this->name]['_errors'][] = $this->parseError($validation->getError());
                        }
                    }
                }

                if (!empty($this->sub_types)) {

                    foreach ($data[$this->name] as $k => $value) {
                        $errors = [];
                        foreach ($this->sub_types as $type) {
                            if (!$type->validate($data[$this->name][$k])) {
                                $errors += $type->getErrors();
                            }
                        }
                        $this->errors[$this->name]['_alias'] = $this->name;
                        $this->errors[$this->name]['_field_name'] = $this->alias();
                        $this->errors[$this->name]['_fields'][$this->name . '.' . $k]['_field_name'] = $this->name;
                        $this->errors[$this->name]['_fields'][$this->name . '.' . $k]['_alias'] = $this->alias($k);
                        $this->errors[$this->name]['_fields'][$this->name . '.' . $k]['_fields'] = $errors;
                    }

                } else {
                    foreach ($data[$this->name] as $k => $value) {
                        foreach ($this->validations as $validation) {
                            if (!$validation->validate($value)) {
                                $this->errors[$this->name]['_alias'] = $this->name;
                                $this->errors[$this->name]['_field_name'] = $this->alias();
                                $this->errors[$this->name]['_fields'][$this->name . '.' . $k]['_field_name'] = $this->name;
                                $this->errors[$this->name]['_fields'][$this->name . '.' . $k]['_alias'] = $this->alias($k);
                                $this->errors[$this->name]['_fields'][$this->name . '.' . $k]['_errors'][] = $this->parseError($validation->getError());
                            }
                        }
                    }
                }

            } elseif (!empty($this->sub_types)) {
                $errors = [];
                foreach ($this->sub_types as $type) {
                    if (!$type->validate($data[$this->name])) {
                        $errors += $type->getErrors();
                    }
                }
                if (!empty($errors)) {
                    $this->errors[$this->name]['_field_name'] = $this->name;
                    $this->errors[$this->name]['_alias'] = $this->alias();
                    $this->errors[$this->name]['_fields'] = $errors;
                }
            } else {
                foreach ($this->validations as $validation) {
                    if (!$validation->validate($data[$this->name])) {
                        $this->errors[$this->name]['_field_name'] = $this->name;
                        $this->errors[$this->name]['_alias'] = $this->alias();
                        $this->errors[$this->name]['_errors'][] = $this->parseError($validation->getError());
                    }
                }
            }

        } else {
            foreach ($this->validations as $validation) {
                if ($validation instanceof ValidRequired) {
                    $this->errors[$this->name]['_field_name'] = $this->name;
                    $this->errors[$this->name]['_alias'] = $this->alias();
                    $this->errors[$this->name]['_errors'][] = $this->parseError($validation->getError());
                }
            }
        }

        return empty($this->errors);
    }

    protected function parseError($error)
    {
        return "$error:{$this->name}:{$this->alias()}";
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

    protected function alias($position = false)
    {
        $alias = $this->alias ? $this->alias : $this->name;
        if ($position !== false) {
            $alias .= ' ' . ($position + 1);
        }
        return $alias;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}