<?php
declare(strict_types=1);

namespace Ajasta\Domain\Invoice;

final class InvoiceNumber
{
    /**
     * @var string
     */
    private $value;

    private function __construct()
    {
    }

    /**
     * @param string $value
     * @return InvoiceNumber
     */
    public static function fromString($value)
    {
        $invoiceNumber = new self();
        $invoiceNumber->value = $value;

        return $invoiceNumber;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->value;
    }
}
