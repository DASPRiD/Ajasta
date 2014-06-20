<?php
namespace Ajasta\Invoice\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoiceServiceFactory implements FactoryInterface
{
    /**
     * @return InvoiceService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        return new InvoiceService(
            $objectManager,
            $serviceLocator->get('Ajasta\Core\TransactionalManager'),
            $serviceLocator->get('Ajasta\Invoice\Repository\InvoiceNumberIncrementerRepository'),
            $serviceLocator->get('Ajasta\Invoice\Service\InvoiceNumberGenerator\GeneratorInterface'),
            $serviceLocator->get('Ajasta\Invoice\Pdf\InvoicePrinter'),
            $serviceLocator->get('Ajasta\Invoice\Options')->getInvoicePath()
        );
    }
}
