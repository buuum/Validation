<?php

namespace Buuum\Filters;

class FilterEmail implements Filter
{

    public function filter($value)
    {
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }

}