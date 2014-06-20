<?php
namespace Ajasta\Invoice\Service;

use Ajasta\Invoice\Entity\Invoice;
use Ajasta\Invoice\Entity\InvoiceNumberIncrementer;
use Ajasta\Invoice\Printer\InvoicePrinter;
use Ajasta\Invoice\Repository\InvoiceNumberIncrementerRepository;
use Ajasta\Invoice\Service\InvoiceNumberGenerator\GeneratorInterface;
use DateTime;
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
     * @var InvoicePrinter
     */
    protected $invoicePrinter;

    /**
     * @var string
     */
    protected $invoicePath;

    /**
     * @param ObjectManager                      $objectManager
     * @param callable                           $transactionalManager
     * @param InvoiceNumberIncrementerRepository $invoiceNumberIncrementerRepository
     * @param GeneratorInterface                 $invoiceNumberGenerator
     * @param InvoicePrinter                     $invoicePrinter
     * @param string                             $invoicePath
     */
    public function __construct(
        ObjectManager $objectManager,
        callable $transactionalManager,
        InvoiceNumberIncrementerRepository $invoiceNumberIncrementerRepository,
        GeneratorInterface $invoiceNumberGenerator,
        InvoicePrinter $invoicePrinter,
        $invoicePath
    ) {
        $this->objectManager                      = $objectManager;
        $this->transactionalManager               = $transactionalManager;
        $this->invoiceNumberIncrementerRepository = $invoiceNumberIncrementerRepository;
        $this->invoiceNumberGenerator             = $invoiceNumberGenerator;
        $this->invoicePrinter                     = $invoicePrinter;
        $this->invoicePath                        = $invoicePath;
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

        $invoicePath = $this->getInvoicePath($invoice);

        if (file_exists($invoicePath)) {
            unlink($invoicePath);
        }
    }

    /**
     * @param Invoice $invoice
     * @param string  $status
     */
    public function changeStatus(Invoice $invoice, $status)
    {
        switch ($status) {
            case 'draft':
                $invoice->setSendDate(null);
                $invoice->setPayDate(null);
                break;

            case 'sent':
                if ($invoice->getSendDate() === null) {
                    $invoice->setSendDate(new DateTime());
                }

                $invoice->setPayDate(null);
                break;

            case 'paid':
                if ($invoice->getSendDate() === null) {
                    $invoice->setSendDate(new DateTime());
                }

                if ($invoice->getPayDate() === null) {
                    $invoice->setPayDate(new DateTime());
                }
                break;

            default:
                throw new RuntimeException(sprintf(
                    'Invalid status: %s',
                    $status
                ));
        }

        $this->persist($invoice);
    }

    /**
     * @param  Invoice $invoice
     * @return string
     */
    public function generatePdf(Invoice $invoice)
    {
        $invoicePath = $this->getInvoicePath($invoice);

        if (!file_exists($invoicePath)) {
            $this->invoicePrinter->generatePdf($invoice, $invoicePath);
        }

        return $invoicePath;
    }

    /**
     * @param  Invoice $invoice
     * @return string
     */
    protected function getInvoicePath(Invoice $invoice)
    {
        return sprintf('%s/invoice-%d.pdf', $this->invoicePath, $invoice->getId());
    }
}
