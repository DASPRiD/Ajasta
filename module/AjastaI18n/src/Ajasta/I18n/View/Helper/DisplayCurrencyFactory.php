<?php
namespace Ajasta\I18n\View\Helper;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DisplayCurrencyFactory implements FactoryInterface
{
    /**
     * @return DisplayCurrency
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        return new DisplayCurrency($serviceLocator->get('Ajasta\I18n\Cldr\Manager'));
    }
}
