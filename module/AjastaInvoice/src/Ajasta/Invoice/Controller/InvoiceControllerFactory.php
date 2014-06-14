<?php
namespace Ajasta\Invoice\Controller;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoiceControllerFactory implements FactoryInterface
{
    /**
     * @return InvoiceController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        return new InvoiceController(
            $serviceLocator->get('Ajasta\Invoice\Repository\InvoiceRepository'),
            $serviceLocator->get('Ajasta\Invoice\Service\InvoiceService'),
            $serviceLocator->get('FormElementManager')->get('Ajasta\Invoice\Form\InvoiceForm'),
            $serviceLocator->get('Ajasta\Invoice\Datatable\Formatter')
        );
    }
}
