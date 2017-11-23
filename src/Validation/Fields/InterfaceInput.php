<?php

namespace RequestCheck\Fields;

interface InterfaceInput
{
    public function filter($data);

    public function validate($data);
    
}