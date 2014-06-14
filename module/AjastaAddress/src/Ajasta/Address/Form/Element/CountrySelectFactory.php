<?php
namespace Ajasta\Address\Form\Element;

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

        return new CountrySelect(
            $serviceLocator->get('Ajasta\Address\Service\AddressService'),
            $serviceLocator->get('Ajasta\I18n\Cldr\Manager')
        );
    }
}
