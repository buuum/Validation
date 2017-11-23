<?php

namespace RequestCheck\Fields;

class Input extends AbstractInput
{
    public function filter($data)
    {
        foreach ($this->filters as $filter) {
            $data = $filter->filter($data);
        }

        return $data;
    }

    public function validate($data)
    {
        $this->errors_class = new InputError($this);

        foreach ($this->validations as $validation) {
            if (!$validation->validate($data)) {
                $this->errors_class->addError(new MessageError($this, $validation));
            }
        }

        return $this->errors_class->isValid();
    }

}