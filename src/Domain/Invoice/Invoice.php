<?php
declare(strict_types=1);

namespace Ajasta\Domain\Invoice;

use Ajasta\Domain\CurrencyCode;
use Ajasta\Domain\Locale;
use Ajasta\Domain\VatPercentage;
use Ajasta\Invoicing\Entity\LineItem;
use Ajasta\Invoicing\InvoiceNumber;
use Assert\Assertion;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Invoice
{
    /**
     * @var InvoiceId
     */
    private $invoiceId;

    /**
     * @var InvoiceNumber
     */
    private $invoiceNumber;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Project|null
     */
    private $project;

    /**
     * @var Locale
     */
    private $locale;

    /**
     * @var CurrencyCode
     */
    private $currencyCode;

    /**
     * @var DateTimeImmutable
     */
    private $issueDate;

    /**
     * @var DateTimeImmutable
     */
    private $dueDate;

    /**
     * @var DateTimeImmutable|null
     */
    private $transmissionDate;

    /**
     * @var DateTimeImmutable|null
     */
    private $paymentReceiptDate;

    /**
     * @var VatPercentage
     */
    private $vatPercentage;

    /**
     * @var LineItem[]|Collection
     */
    private $lineItems;

    private function __construct()
    {
        $this->invoiceId = new InvoiceId();
        $this->lineItems = new ArrayCollection();
    }

    public static function newInvoice(
        InvoiceNumber $invoiceNumber,
        Client $client,
        Locale $locale,
        CurrencyCode $currencyCode,
        DateTimeImmutable $issueDate,
        DateTimeImmutable $dueDate,
        VatPercentage $vatPercentage,
        array $lineItems,
        Project $project = null
    ) : self {
        $invoice = new self();
        $invoice->invoiceNumber = $invoiceNumber;
        $invoice->update($client, $locale, $currencyCode, $issueDate, $dueDate, $vatPercentage, $lineItems, $project);

        return $invoice;
    }

    public function update(
        Client $client,
        Locale $locale,
        CurrencyCode $currencyCode,
        DateTimeImmutable $issueDate,
        DateTimeImmutable $dueDate,
        VatPercentage $vatPercentage,
        array $lineItems,
        Project $project = null
    ) {
        $this->client = $client;
        $this->locale = $locale;
        $this->currencyCode = $currencyCode;
        $this->issueDate = $issueDate;
        $this->dueDate = $dueDate;
        $this->vatPercentage = $vatPercentage;
        $this->project = $project;

        $this->lineItems->clear();

        foreach ($lineItems as $lineItem) {
            $this->lineItems->add($lineItem);
        }
    }

    public function getInvoiceId() : InvoiceId
    {
        return $this->invoiceId;
    }

    public function toInvoiceNumber() : InvoiceNumber
    {
        return $this->invoiceNumber;
    }

    public function getClient() : Client
    {
        return $this->client;
    }

    public function hasProject() : bool
    {
        return null !== $this->project;
    }

    public function getProject() : Project
    {
        Assertion::notNull($this->project);
        return $this->project;
    }

    public function getLocale() : Locale
    {
        return $this->locale;
    }

    public function getCurrencyCode() : CurrencyCode
    {
        return $this->currencyCode;
    }

    public function getIssueDate() : DateTimeImmutable
    {
        return $this->issueDate;
    }

    public function getDueDate() : DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function hasTransmissionDate() : bool
    {
        return null !== $this->transmissionDate;
    }

    public function getTransmissionDate() : DateTimeImmutable
    {
        Assertion::notNull($this->transmissionDate);
        return $this->transmissionDate;
    }

    public function hasPaymentReceiptDate() : bool
    {
        return null !== $this->paymentReceiptDate;
    }

    public function getPaymentReceiptDate() : DateTimeImmutable
    {
        Assertion::notNull($this->paymentReceiptDate);
        return $this->paymentReceiptDate;
    }

    public function getVatPercentage() : VatPercentage
    {
        return $this->vatPercentage;
    }

    /**
     * @return LineItem[]
     */
    public function getLineItems() : array
    {
        return $this->lineItems->toArray();
    }
}
