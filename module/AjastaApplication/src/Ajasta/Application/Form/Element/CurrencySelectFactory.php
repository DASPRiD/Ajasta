<?php
namespace Ajasta\Application\Form\Element;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CurrencySelectFactory implements FactoryInterface
{
    /**
     * @return CurrencySelect
     */
    public function createService(ServiceLocatorInterface $viewHelperManager)
    {
        return new CurrencySelect($viewHelperManager->getServiceLocator()->get('Ajasta\I18n\Cldr\Manager'));
    }
}
