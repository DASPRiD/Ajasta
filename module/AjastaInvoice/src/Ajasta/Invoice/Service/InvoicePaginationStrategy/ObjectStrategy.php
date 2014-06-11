<?php
namespace Ajasta\Invoice\Service\InvoicePaginationStrategy;

use Doctrine\Common\Persistence\ObjectRepository;
use RuntimeException;

class ObjectStrategy implements StrategyInterface
{
    /**
     * @var ObjectRepository
     */
    protected $invoiceRepository;

    /**
     * @param ObjectRepository $invoiceRepository
     */
    public function __construct(ObjectRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function paginate($offset, $limit, $status = null)
    {
        throw new RuntimeException('Not implemented');
    }
}
