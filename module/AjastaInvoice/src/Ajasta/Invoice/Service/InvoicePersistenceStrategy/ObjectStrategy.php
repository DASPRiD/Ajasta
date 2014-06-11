<?php
namespace Ajasta\Invoice\Service\InvoicePersistenceStrategy;

use Ajasta\Invoice\Entity\Invoice;
use Ajasta\Invoice\Entity\InvoiceNumberIncrementer;
use Ajasta\Invoice\Service\InvoiceNumberGenerator\GeneratorInterface as InvoiceNumberGeneratorInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class ObjectStrategy implements StrategyInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $invoiceNumberIncrementerRepository;

    /**
     * @var InvoiceNumberGeneratorInterface
     */
    protected $invoiceNumberGenerator;

    /**
     * @param ObjectManager                   $objectManger
     * @param ObjectRepository                $invoiceNumberIncrementerRepository
     * @param InvoiceNumberGeneratorInterface $invoiceNumberGenerator
     */
    public function __construct(
        ObjectManager $objectManger,
        ObjectRepository $invoiceNumberIncrementerRepository,
        InvoiceNumberGeneratorInterface $invoiceNumberGenerator
    ) {
        $this->objectManager                      = $objectManger;
        $this->invoiceNumberIncrementerRepository = $invoiceNumberIncrementerRepository;
        $this->invoiceNumberGenerator             = $invoiceNumberGenerator;
    }

    public function persist(Invoice $invoice)
    {
        if ($invoice->getInvoiceNumber() === null) {
            $invoiceNumberIncrememter = $this->invoiceNumberIncrementerRepository->find(
                InvoiceNumberIncrementer::ID
            );

            $invoice->setInvoiceNumber(
                $this->invoiceNumberGenerator->generate(
                    $invoice,
                    $invoiceNumberIncrememter->getValue()
                )
            );

            $invoiceNumberIncrememter->incrementValue();
            $this->objectManager->persist($invoiceNumberIncrememter);
        }

        $this->objectManager->persist($invoice);
        $this->objectManager->flush();
    }
}
