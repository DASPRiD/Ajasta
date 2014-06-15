<?php
namespace Ajasta\Address\View\Helper;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressFormatFactory implements FactoryInterface
{
    /**
     * @return AddressFormat
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        /* @var $addressService \Ajasta\Address\Service\AddressService */
        $addressService = $serviceLocator->get('Ajasta\Address\Service\AddressService');

        return new AddressFormat($addressService);
    }
}
