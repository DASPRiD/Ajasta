<?php
namespace Ajasta\I18n\View\Helper;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DisplayCurrencyFactory implements FactoryInterface
{
    /**
     * @return DisplayCurrency
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        return new DisplayCurrency(
            $serviceLocator->get('Ajasta\I18n\Cldr\Manager')
        );
    }
}
