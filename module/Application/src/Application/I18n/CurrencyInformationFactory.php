<?php
namespace Application\I18n;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CurrencyInformationFactory implements FactoryInterface
{
    /**
     * @return CurrencyInformation
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new CurrencyInformation('data/CLDR');
    }
}