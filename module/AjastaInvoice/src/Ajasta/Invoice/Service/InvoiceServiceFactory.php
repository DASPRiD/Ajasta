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
            $objectManager->getRepository('Ajasta\Invoice\Entity\Invoice')
        );
    }
}
