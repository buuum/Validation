<?php

namespace RequestCheck\Filters;

class FilterCustomTags implements Filter
{

    private $tags;

    public function __construct($tags)
    {
        $this->tags = $tags;
    }

    public function filter($value)
    {
        return strip_tags($value, $this->tags);
    }

}