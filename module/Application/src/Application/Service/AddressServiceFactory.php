<?php
namespace Application\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressServiceFactory implements FactoryInterface
{
    /**
     * @return AddressService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new AddressService('data/AddressFormats');
    }
}