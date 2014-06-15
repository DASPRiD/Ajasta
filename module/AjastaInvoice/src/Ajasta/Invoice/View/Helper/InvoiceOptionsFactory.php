<?php
namespace Ajasta\Invoice\View\Helper;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoiceOptionsFactory implements FactoryInterface
{
    /**
     * @return InvoiceOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        return new InvoiceOptions($serviceLocator->get('Ajasta\Invoice\Options'));
    }
}
