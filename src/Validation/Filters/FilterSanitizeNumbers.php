<?php

namespace RequestCheck\Filters;

class FilterSanitizeNumbers implements Filter
{

    public function filter($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

}