<?php
namespace Ajasta\Invoice\Service\InvoicePersistenceStrategy;

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
        $objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        $invoiceNumberIncrementerRepository = $objectManager->getRepository(
            'Ajasta\Invoice\Entity\InvoiceNumberIncrementer'
        );

        $invoiceNumberGenerator = $serviceLocator->get(
            'Ajasta\Invoice\Service\InvoiceNumberGenerator\GeneratorInterface'
        );

        if ($objectManager instanceof EntityManager) {
            return new EntityStrategy(
                $objectManager,
                $invoiceNumberIncrementerRepository,
                $invoiceNumberGenerator
            );
        }

        return new ObjectStrategy(
            $objectManager,
            $invoiceNumberIncrementerRepository,
            $invoiceNumberGenerator
        );
    }
}
