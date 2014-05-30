<?php
namespace Ajasta\Core\Entity;

class InvoiceItem
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Invoice
     */
    protected $invoice;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var decimal
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $unit;

    /**
     * @var decimal
     */
    protected $unitPrice;

    /**
     * @return decimal
     */
    public function getAmount()
    {
        return bcmul($this->quantity, $this->unitPrice, 2);
    }
}
