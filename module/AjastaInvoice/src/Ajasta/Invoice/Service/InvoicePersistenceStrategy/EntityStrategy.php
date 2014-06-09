<?php
namespace Ajasta\Invoice\Service\InvoicePersistenceStrategy;

use Ajasta\Invoice\Entity\Invoice;
use Ajasta\Invoice\Entity\InvoiceNumberIncrementer;
use Ajasta\Invoice\Service\InvoiceNumberGenerator\GeneratorInterface as InvoiceNumberGeneratorInterface;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class EntityStrategy implements StrategyInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var EntityRepository
     */
    protected $invoiceNumberIncrementerRepository;

    /**
     * @var InvoiceNumberGeneratorInterface
     */
    protected $invoiceNumberGenerator;

    /**
     * @param EntityManager                   $entityManger
     * @param EntityRepository                $invoiceNumberIncrementerRepository
     * @param InvoiceNumberGeneratorInterface $invoiceNumberGenerator
     */
    public function __construct(
        EntityManager $entityManger,
        EntityRepository $invoiceNumberIncrementerRepository,
        InvoiceNumberGeneratorInterface $invoiceNumberGenerator
    ) {
        $this->entityManager                      = $entityManger;
        $this->invoiceNumberIncrementerRepository = $invoiceNumberIncrementerRepository;
        $this->invoiceNumberGenerator             = $invoiceNumberGenerator;
    }

    public function persist(Invoice $invoice)
    {
        $this->entityManager->transactional(function () use ($invoice) {
            if ($invoice->getInvoiceNumber() === null) {
                $invoiceNumberIncrememter = $this->invoiceNumberIncrementerRepository->find(
                    InvoiceNumberIncrementer::ID,
                    LockMode::PESSIMISTIC_WRITE
                );

                $invoice->setInvoiceNumber(
                    $this->invoiceNumberGenerator->generate(
                        $invoice,
                        $invoiceNumberIncrememter->getValue()
                    )
                );

                $this->entityManager->persist($invoice);
            }

            $this->entityManager->persist($invoice);
        });
    }
}
