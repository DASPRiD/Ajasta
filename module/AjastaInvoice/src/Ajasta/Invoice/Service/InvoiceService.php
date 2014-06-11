<?php
namespace Ajasta\Invoice\Service;

use Ajasta\Invoice\Entity\Invoice;
use Ajasta\Invoice\Service\InvoicePaginationStrategy\PaginationResult;
use Ajasta\Invoice\Service\InvoicePaginationStrategy\StrategyInterface as InvoicePaginationStrategyInterface;
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
     * @var InvoicePaginationStrategyInterface
     */
    protected $invoicePaginationStrategy;

    /**
     * @param ObjectManager                       $objectManager
     * @param ObjectRepository                    $invoiceRepository
     * @param InvoicePersistenceStrategyInterface $invoicePersistenceStrategy
     * @param InvoicePaginationStrategyInterface  $invoicePaginationStrategy
     */
    public function __construct(
        ObjectManager $objectManager,
        ObjectRepository $invoiceRepository,
        InvoicePersistenceStrategyInterface $invoicePersistenceStrategy,
        InvoicePaginationStrategyInterface $invoicePaginationStrategy
    ) {
        $this->objectManager              = $objectManager;
        $this->invoiceRepository          = $invoiceRepository;
        $this->invoicePersistenceStrategy = $invoicePersistenceStrategy;
        $this->invoicePaginationStrategy  = $invoicePaginationStrategy;
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
     * @param  int         $offset
     * @param  int         $limit
     * @param  string|null $status
     * @return PaginationResult
     */
    public function paginate($offset, $limit, $status = null)
    {
        return $this->invoicePaginationStrategy->paginate($offset, $limit, $status);
    }

    /**
     * @param Invoice $invoice
     */
    public function persist(Invoice $invoice)
    {
        $this->invoicePersistenceStrategy->persist($invoice);
    }
}
