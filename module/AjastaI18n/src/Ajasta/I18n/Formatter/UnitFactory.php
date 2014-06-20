<?php
namespace Ajasta\I18n\Formatter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UnitFactory implements FactoryInterface
{
    /**
     * @return Unit
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Unit(
            $serviceLocator->get('Ajasta\I18n\Cldr\Manager')
        );
    }
}
