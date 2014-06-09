<?php
namespace Ajasta\Invoice\Service\InvoiceNumberGenerator;

use Ajasta\Invoice\Entity\Invoice;

interface GeneratorInterface
{
    /**
     * Generates a new invoice number for an invoice with a given incrememter.
     *
     * @param  Invoice $invoice
     * @param  int     $incrementer
     * @return string
     */
    public function generate(Invoice $invoice, $incrementer);
}
