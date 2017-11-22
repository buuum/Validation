<?php

namespace RequestCheck\Filters;

class FilterString implements Filter
{

    public function filter($value)
    {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }

}