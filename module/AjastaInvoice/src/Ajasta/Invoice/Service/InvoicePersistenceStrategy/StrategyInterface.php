<?php
namespace Ajasta\Invoice\Service\InvoicePersistenceStrategy;

use Ajasta\Invoice\Entity\Invoice;

interface StrategyInterface
{
    /**
     * Persists an invoice and, if not already set, injects a generated invoice
     * number into the invoice.
     *
     * @param Invoice $invoice
     */
    public function persist(Invoice $invoice);
}
