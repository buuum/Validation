<?php

namespace RequestCheck\Filters;

class FilterUrlEncode implements Filter
{

    public function filter($value)
    {
        return filter_var($value, FILTER_SANITIZE_ENCODED);
    }

}