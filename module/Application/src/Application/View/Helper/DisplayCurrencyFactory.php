<?php
namespace Application\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DisplayCurrencyFactory implements FactoryInterface
{
    /**
     * @return DisplayCurrency
     */
    public function createService(ServiceLocatorInterface $viewHelperManager)
    {
        return new DisplayCurrency(
            $viewHelperManager->getServiceLocator()->get('Application\I18n\CurrencyInformation')
        );
    }
}