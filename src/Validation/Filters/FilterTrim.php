<?php

namespace RequestCheck\Filters;

class FilterTrim implements Filter
{

    public function filter($value)
    {
        return trim($value);
    }

}