<?php
namespace Ajasta\I18n\Cldr;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ManagerFactory implements FactoryInterface
{
    /**
     * @return Manager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Manager($serviceLocator->get('Ajasta\I18n\Cldr\Reader'));
    }
}
