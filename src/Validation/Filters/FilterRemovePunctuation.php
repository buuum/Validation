<?php

namespace RequestCheck\Filters;

class FilterRemovePunctuation implements Filter
{

    public function filter($value)
    {
        return preg_replace("/(?![.=$'€%-])\p{P}/u", '', $value);
    }

}