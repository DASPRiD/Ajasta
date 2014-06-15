<?php
namespace Ajasta\Invoice\Service;

use Ajasta\Invoice\Entity\Invoice;
use Ajasta\Invoice\Entity\InvoiceNumberIncrementer;
use Ajasta\Invoice\Repository\InvoiceNumberIncrementerRepository;
use Ajasta\Invoice\Service\InvoiceNumberGenerator\GeneratorInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RuntimeException;

class InvoiceService
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var callable
     */
    protected $transactionalManager;

    /**
     * @var InvoiceNumberIncrementerRepository
     */
    protected $invoiceNumberIncrementerRepository;

    /**
     * @var GeneratorInterface
     */
    protected $invoiceNumberGenerator;

    /**
     * @param ObjectManager                      $objectManager
     * @param callable                           $transactionalManager
     * @param InvoiceNumberIncrementerRepository $invoiceNumberIncrementerRepository
     * @param GeneratorInterface                 $invoiceNumberGenerator
     */
    public function __construct(
        ObjectManager $objectManager,
        callable $transactionalManager,
        InvoiceNumberIncrementerRepository $invoiceNumberIncrementerRepository,
        GeneratorInterface $invoiceNumberGenerator
    ) {
        $this->objectManager                      = $objectManager;
        $this->transactionalManager               = $transactionalManager;
        $this->invoiceNumberIncrementerRepository = $invoiceNumberIncrementerRepository;
        $this->invoiceNumberGenerator             = $invoiceNumberGenerator;
    }

    /**
     * @param Invoice $invoice
     */
    public function persist(Invoice $invoice)
    {
        if ($invoice->getInvoiceNumber() !== null) {
            $this->objectManager->persist($invoice);
            $this->objectManager->flush();
            return;
        }

        $transactionalManager = $this->transactionalManager;
        $transactionalManager(function () use ($invoice) {
            $invoiceNumberIncrememter = $this->invoiceNumberIncrementerRepository->findWithWriteLock(
                InvoiceNumberIncrementer::ID
            );

            if ($invoiceNumberIncrememter === null) {
                throw new RuntimeException(sprintf(
                    'Missing invoice number incrementer with id %d',
                    InvoiceNumberIncrementer::ID
                ));
            }

            $invoice->setInvoiceNumber(
                $this->invoiceNumberGenerator->generate(
                    $invoice,
                    $invoiceNumberIncrememter->getValue()
                )
            );

            $invoiceNumberIncrememter->incrementValue();
            $this->objectManager->persist($invoiceNumberIncrememter);
            $this->objectManager->persist($invoice);
        });
    }
}
