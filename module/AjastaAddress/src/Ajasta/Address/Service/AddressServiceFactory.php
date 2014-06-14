<?php
namespace Ajasta\Address\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressServiceFactory implements FactoryInterface
{
    /**
     * @return AddressService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new AddressService($serviceLocator->get('Ajasta\Address\Options'));
    }
}
