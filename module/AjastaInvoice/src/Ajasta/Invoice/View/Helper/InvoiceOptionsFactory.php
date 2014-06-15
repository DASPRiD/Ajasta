<?php
namespace Ajasta\Invoice\View\Helper;

use Ajasta\Invoice\Options;
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

        /* @var $options Options */
        $options = $serviceLocator->get('Ajasta\Invoice\Options');

        return new InvoiceOptions($options);
    }
}
