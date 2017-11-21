<?php

namespace Buuum\Filters;

class FilterTrim implements Filter
{

    public function filter($value)
    {
        return trim($value);
    }

}