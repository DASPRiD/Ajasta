<?php
namespace Ajasta\Invoice\Service\InvoicePaginationStrategy;

use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StrategyFactory implements FactoryInterface
{
    /**
     * @return StrategyInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $objectManager     = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $invoiceRepository = $objectManager->getRepository('Ajasta\Invoice\Entity\Invoice');

        if ($objectManager instanceof EntityManager) {
            return new EntityStrategy($invoiceRepository);
        }

        return new ObjectStrategy($invoiceRepository);
    }
}
