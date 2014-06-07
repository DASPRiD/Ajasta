<?php
namespace Ajasta\Invoice\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoiceControllerFactory implements FactoryInterface
{
    /**
     * @return InvoiceController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();

        return new InvoiceController(
            $serviceLocator->get('Ajasta\Invoice\Service\InvoiceService'),
            $serviceLocator->get('FormElementManager')->get('Ajasta\Invoice\Form\InvoiceForm')
        );
    }
}
