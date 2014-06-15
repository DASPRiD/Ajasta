<?php
namespace Ajasta\Invoice\Controller;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoiceControllerFactory implements FactoryInterface
{
    /**
     * @return InvoiceController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator     = FactoryUtils::resolveServiceLocator($serviceLocator);
        $formElementManager = $serviceLocator->get('FormElementManager');

        return new InvoiceController(
            $serviceLocator->get('Ajasta\Invoice\Repository\InvoiceRepository'),
            $serviceLocator->get('Ajasta\Invoice\Service\InvoiceService'),
            $formElementManager->get('Ajasta\Invoice\Form\InvoiceForm'),
            $serviceLocator->get('Ajasta\Invoice\Datatable\Formatter')
        );
    }
}
