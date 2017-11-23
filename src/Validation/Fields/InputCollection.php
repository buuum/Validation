<?php

namespace RequestCheck\Fields;

use Countable;
use IteratorAggregate;
use ArrayIterator;

class InputCollection implements Countable, IteratorAggregate
{

    /**
     * @var InterfaceInput []
     */
    private $elements;

    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            if (!$element instanceof InterfaceInput) {
                throw new \Exception('All elements must implements InterfaceInput');
            }
        }
        $this->elements = $elements;
    }

    public function add(InterfaceInput $element)
    {
        $this->elements[] = $element;

        return true;
    }

    public function remove(InterfaceInput $element)
    {
        foreach ($this->elements as $k => $el) {
            if ($el == $element) {
                unset($this->elements[$k]);
            }
        }
        return $element;
    }

    public function count()
    {
        return count($this->elements);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }
}
