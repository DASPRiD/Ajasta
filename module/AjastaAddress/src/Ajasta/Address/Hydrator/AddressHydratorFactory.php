<?php
namespace Ajasta\Address\Hydrator;

use Ajasta\Address\Service\AddressService;
use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressHydratorFactory implements FactoryInterface
{
    /**
     * @return AddressHydrator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        /* @var $addressService AddressService */
        $addressService = $serviceLocator->get('Ajasta\Address\Service\AddressService');

        return new AddressHydrator($addressService);
    }
}
