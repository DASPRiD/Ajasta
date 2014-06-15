<?php
namespace Ajasta\Address\Controller;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        /* @var $addressService \Ajasta\Address\Service\AddressService */
        $addressService = $serviceLocator->get('Ajasta\Address\Service\AddressService');

        return new IndexController($addressService);
    }
}
