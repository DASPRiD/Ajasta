<?php
namespace Ajasta\Core\Form\Element;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CurrencySelectFactory implements FactoryInterface
{
    /**
     * @return CurrencySelect
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        return new CurrencySelect(
            $serviceLocator->get('Ajasta\I18n\Cldr\Manager')
        );
    }
}
