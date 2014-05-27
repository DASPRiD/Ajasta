<?php
namespace Application\Hydrator;

use Application\Hydrator\Strategy\NullStringStrategy;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ClientHydrator extends ClassMethodsHydrator
{
    public function __construct()
    {
        parent::__construct(false);

        $nullStringStrategy = new NullStringStrategy();

        $this->addStrategy('defaultUnit', $nullStringStrategy);
        $this->addStrategy('defaultUnitPrice', $nullStringStrategy);
    }
}
