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

        return new CountrySelect(
            $serviceLocator->get('Ajasta\Address\Service\AddressService'),
            $serviceLocator->get('Ajasta\I18n\Cldr\Manager')
        );
    }
}
