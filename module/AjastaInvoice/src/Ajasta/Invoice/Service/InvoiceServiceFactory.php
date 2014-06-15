<?php
namespace Ajasta\Invoice\Service;

use Ajasta\Invoice\Repository\InvoiceNumberIncrementerRepository;
use Ajasta\Invoice\Service\InvoiceNumberGenerator\GeneratorInterface;
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
            $serviceLocator->get('Ajasta\Invoice\Service\InvoiceNumberGenerator\GeneratorInterface')
        );
    }
}
