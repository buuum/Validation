<?php

namespace RequestCheck\Filters;

class FilterAttributes implements Filter
{

    public function filter($value)
    {
        return preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $value);
    }

}