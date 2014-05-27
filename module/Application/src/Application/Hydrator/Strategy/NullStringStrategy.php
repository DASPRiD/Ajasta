<?php
namespace Application\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class NullStringStrategy implements StrategyInterface
{
    public function extract($value)
    {
        return ($value === null ? '' : $value);
    }

    public function hydrate($value)
    {
        return ($value === '' ? null : $value);
    }
}