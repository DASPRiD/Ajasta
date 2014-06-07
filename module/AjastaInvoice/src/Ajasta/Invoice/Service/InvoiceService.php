<?php
namespace Ajasta\Invoice\Service;

use Ajasta\Invoice\Entity\Invoice;
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
     * @param ObjectManager    $objectManager
     * @param ObjectRepository $invoiceRepository
     */
    public function __construct(ObjectManager $objectManager, ObjectRepository $invoiceRepository)
    {
        $this->objectManager     = $objectManager;
        $this->invoiceRepository = $invoiceRepository;
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
        $this->objectManager->persist($invoice);
        $this->objectManager->flush();
    }
}
