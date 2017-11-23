<?php

namespace RequestCheck\Filters;

class FilterTags implements Filter
{

    public function filter($value)
    {
        return strip_tags($value);
    }

}