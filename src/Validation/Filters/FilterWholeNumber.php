<?php

namespace RequestCheck\Filters;

class FilterWholeNumber implements Filter
{

    public function filter($value)
    {
        return intval($value);
    }

}