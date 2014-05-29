<?php
namespace Ajasta\I18n\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DisplayCurrencyFactory implements FactoryInterface
{
    /**
     * @return DisplayCurrency
     */
    public function createService(ServiceLocatorInterface $viewHelperManager)
    {
        return new DisplayCurrency($viewHelperManager->getServiceLocator()->get('Ajasta\I18n\Cldr\Manager'));
    }
}