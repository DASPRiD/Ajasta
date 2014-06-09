<?php
namespace Ajasta\Invoice\Service;

use Ajasta\Invoice\Entity\Invoice;
use Ajasta\Invoice\Service\InvoicePersistenceStrategy\StrategyInterface as InvoicePersistenceStrategyInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class InvoiceService
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $invoiceRepository;

    /**
     * @var InvoicePersistenceStrategyInterface
     */
    protected $invoicePersistenceStrategy;

    /**
     * @param ObjectManager                       $objectManager
     * @param ObjectRepository                    $invoiceRepository
     * @param InvoicePersistenceStrategyInterface $invoicePersistenceStrategy
     */
    public function __construct(
        ObjectManager $objectManager,
        ObjectRepository $invoiceRepository,
        InvoicePersistenceStrategyInterface $invoicePersistenceStrategy
    ) {
        $this->objectManager              = $objectManager;
        $this->invoiceRepository          = $invoiceRepository;
        $this->invoicePersistenceStrategy = $invoicePersistenceStrategy;
    }

    /**
     * @param  int $invoiceId
     * @return Invoice|null
     */
    public function find($invoiceId)
    {
        return $this->invoiceRepository->find($invoiceId);
    }

    /**
     * @return Invoice[]
     */
    public function findAll()
    {
        return $this->invoiceRepository->findAll();
    }

    /**
     * @param Invoice $invoice
     */
    public function persist(Invoice $invoice)
    {
        $this->invoicePersistenceStrategy->persist($invoice);
    }
}
