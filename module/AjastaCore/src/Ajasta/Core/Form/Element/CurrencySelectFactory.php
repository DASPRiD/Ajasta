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

        /* @var $cldrManager \Ajasta\I18n\Cldr\Manager */
        $cldrManager = $serviceLocator->get('Ajasta\I18n\Cldr\Manager');

        return new CurrencySelect($cldrManager);
    }
}
