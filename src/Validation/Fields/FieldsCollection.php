<?php

namespace RequestCheck\Fields;

use Countable;
use IteratorAggregate;
use ArrayIterator;

class FieldsCollection implements Countable, IteratorAggregate
{

    /**
     * @var Field []
     */
    private $elements;

    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            if (!$element instanceof Field) {
                throw new \Exception('All elements must be Field class');
            }
        }
        $this->elements = $elements;
    }

    public function add(Field $element)
    {
        $this->elements[] = $element;

        return true;
    }

    public function remove(Field $element)
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
