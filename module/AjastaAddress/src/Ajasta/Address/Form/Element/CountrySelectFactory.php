<?php
namespace Ajasta\Address\Form\Element;

use Ajasta\Address\Service\AddressService;
use Ajasta\I18n\Cldr\Manager as CldrManager;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CountrySelectFactory implements FactoryInterface
{
    /**
     * @return CountrySelect
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        /* @var $addressService AddressService */
        /* @var $cldrManager    CldrManager */
        $addressService = $serviceLocator->get('Ajasta\Address\Service\AddressService');
        $cldrManager    = $serviceLocator->get('Ajasta\I18n\Cldr\Manager');

        return new CountrySelect($addressService, $cldrManager);
    }
}
