<?php

namespace RequestCheck\Fields;

class InputArray extends AbstractInput
{
    private $input;

    public function __construct($name, AbstractInput $input)
    {
        $this->input = $input;
        parent::__construct($name);
    }

    public function filter($data)
    {
        foreach ($data as $k => $dataitem) {
            $data[$k] = $this->input->filter($dataitem);
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

        if (is_array($data)) {
            $index = 0;
            foreach ($data as $k => $dataitem) {
                $this->input->setPosition($index);
                if (!$this->input->validate($dataitem)) {
                    $this->errors_class->addSubfield($this->input->getErrors());
                }
                $index++;
            }
        }

        return $this->errors_class->isValid();
    }
}