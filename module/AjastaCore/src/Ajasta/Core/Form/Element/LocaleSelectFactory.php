<?php
namespace Ajasta\Core\Form\Element;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LocaleSelectFactory implements FactoryInterface
{
    /**
     * @return CurrencySelect
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);
        $options        = $serviceLocator->get('Ajasta\Core\Options');

        return new LocaleSelect(
            $options->getSelectableLocales(),
            $options->getDefaultLocale()
        );
    }
}
