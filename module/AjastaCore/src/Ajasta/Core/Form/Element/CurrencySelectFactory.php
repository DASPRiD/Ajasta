<?php
namespace Ajasta\Core\Form\Element;

use Ajasta\Core\FactoryUtils;
use Ajasta\I18n\Cldr\Manager as CldrManager;
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

        /* @var $cldrManager CldrManager */
        $cldrManager = $serviceLocator->get('Ajasta\I18n\Cldr\Manager');

        return new CurrencySelect($cldrManager);
    }
}
