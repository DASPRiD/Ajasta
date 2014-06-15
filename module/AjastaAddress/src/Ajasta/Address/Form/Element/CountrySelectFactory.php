<?php
namespace Ajasta\Address\Form\Element;

use Ajasta\Address\Service\AddressService;
use Ajasta\Core\FactoryUtils;
use Ajasta\I18n\Cldr\Manager as CldrManager;
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

        /* @var $addressService AddressService */
        $addressService = $serviceLocator->get('Ajasta\Address\Service\AddressService');
        /* @var $cldrManager CldrManager */
        $cldrManager = $serviceLocator->get('Ajasta\I18n\Cldr\Manager');

        return new CountrySelect($addressService, $cldrManager);
    }
}
