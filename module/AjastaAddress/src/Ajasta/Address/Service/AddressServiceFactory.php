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
        /* @var $options \Ajasta\Address\Options */
        $options = $serviceLocator->get('Ajasta\Address\Options');

        return new AddressService($options);
    }
}
