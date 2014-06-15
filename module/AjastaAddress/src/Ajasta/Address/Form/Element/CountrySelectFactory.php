<?php
namespace Ajasta\Address\Form\Element;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CountrySelectFactory implements FactoryInterface
{
    /**
     * @return CountrySelect
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        /* @var $addressService \Ajasta\Address\Service\AddressService */
        $addressService = $serviceLocator->get('Ajasta\Address\Service\AddressService');
        /* @var $cldrManager \Ajasta\I18n\Cldr\Manager */
        $cldrManager = $serviceLocator->get('Ajasta\I18n\Cldr\Manager');

        return new CountrySelect($addressService, $cldrManager);
    }
}
