<?php

namespace RequestCheck\Fields;

use RequestCheck\Validations\AbstractValidation;

class MessageError
{

    const DEFAULT_MESSAGE = 'The :attribute is invalid';

    private $input;
    private $validation;

    public function __construct(AbstractInput $input, AbstractValidation $validation)
    {
        $this->input = $input;
        $this->validation = $validation;
    }

    public function input()
    {
        return $this->input;
    }

    public function validation()
    {
        return $this->validation;
    }

    public function message($messages = [])
    {
        if ($message = $this->validation()->message()) {
            return $this->error($message);
        }

        return $this->error($this->getMessage($messages));
    }

    protected function getMessage($messages)
    {
        $classname = get_class($this->validation());
        $message = false;
        if (!empty($messages[$classname])) {
            $message = $messages[$classname];
        }
        return $message ? $message : self::DEFAULT_MESSAGE;
    }

    protected function error($message)
    {
        $message = str_replace([':attribute', ':fieldname'], [$this->input()->alias(), $this->input()->name()],
            $message);
        $message = str_replace([':value', ':value2', ':value3', ':value4', ':value5'], $this->validation()->getVars(),
            $message);
        return $message;
    }

}