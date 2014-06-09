<?php
namespace Ajasta\Invoice\Service\InvoiceNumberGenerator;

use Ajasta\Invoice\Entity\Invoice;

class FormatGenerator implements GeneratorInterface
{
    /**
     * @var string
     */
    protected $invoiceNumberFormat;

    /**
     * @param string $invoiceNumberFormat
     */
    public function __construct($invoiceNumberFormat)
    {
        $this->invoiceNumberFormat = $invoiceNumberFormat;
    }

    public function generate(Invoice $invoice, $incrementer)
    {
        $issueDate = $invoice->getIssueDate();

        return sprintf(
            $this->invoiceNumberFormat,
            $incrementer,
            $issueDate->format('Y'),
            $issueDate->format('m'),
            $issueDate->format('d')
        );
    }
}
