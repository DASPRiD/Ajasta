<?php
namespace Ajasta\Address\Hydrator;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressHydratorFactory implements FactoryInterface
{
    /**
     * @return AddressHydrator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        return new AddressHydrator(
            $serviceLocator->get('Ajasta\Address\Service\AddressService')
        );
    }
}
