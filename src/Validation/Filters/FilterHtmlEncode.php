<?php

namespace RequestCheck\Filters;

class FilterHtmlEncode implements Filter
{

    public function filter($value)
    {
        return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
    }

}