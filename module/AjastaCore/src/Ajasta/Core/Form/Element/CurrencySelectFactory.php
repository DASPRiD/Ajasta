<?php
namespace Ajasta\Core\Form\Element;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CurrencySelectFactory implements FactoryInterface
{
    /**
     * @return CurrencySelect
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        return new CurrencySelect($serviceLocator->get('Ajasta\I18n\Cldr\Manager'));
    }
}
