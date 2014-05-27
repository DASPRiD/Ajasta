<?php
namespace Application\Form\Element;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CurrencySelectFactory implements FactoryInterface
{
    /**
     * @return CurrencySelect
     */
    public function createService(ServiceLocatorInterface $viewHelperManager)
    {
        return new CurrencySelect(
            $viewHelperManager->getServiceLocator()->get('Application\I18n\CurrencyInformation')
        );
    }
}