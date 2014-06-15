<?php
namespace Ajasta\Invoice\Service;

use Ajasta\Invoice\Repository\InvoiceNumberIncrementerRepository;
use Ajasta\Invoice\Service\InvoiceNumberGenerator\GeneratorInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoiceServiceFactory implements FactoryInterface
{
    /**
     * @return InvoiceService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $objectManager ObjectManager */
        $objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        /* @var $transactionalManager callable */
        $transactionalManager = $serviceLocator->get('Ajasta\Core\TransactionalManager');
        /* @var $invoiceNumberIncrementerRepository InvoiceNumberIncrementerRepository */
        $invoiceNumberIncrementerRepository
            = $serviceLocator->get('Ajasta\Invoice\Repository\InvoiceNumberIncrementerRepository');
        /* @var $invoiceNumberGenerator GeneratorInterface */
        $invoiceNumberGenerator
            = $serviceLocator->get('Ajasta\Invoice\Service\InvoiceNumberGenerator\GeneratorInterface');

        return new InvoiceService(
            $objectManager,
            $transactionalManager,
            $invoiceNumberIncrementerRepository,
            $invoiceNumberGenerator
        );
    }
}
