<?php
namespace Ajasta\Invoice\Entity;

use RuntimeException;

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
     * @var int
     */
    protected $position;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var decimal
     */
    protected $quantity;

    /**
     * @var string|null
     */
    protected $unit;

    /**
     * @var decimal
     */
    protected $unitPrice;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @internal
     * @param Invoice $invoice
     */
    public function setInvoice(Invoice $invoice)
    {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS | DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1]['object'];

        if (!$caller instanceof Invoice) {
            throw new RuntimeException(sprintf(
                '%s may only be called by %s\Invoice',
                __METHOD__,
                __NAMESPACE__
            ));
        }

        $this->invoice = $invoice;
    }

    /**
     * @internal
     * @param int $position
     */
    public function setPosition($position)
    {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS | DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1]['object'];

        if (!$caller instanceof Invoice) {
            throw new RuntimeException(sprintf(
                '%s may only be called by %s\Invoice',
                __METHOD__,
                __NAMESPACE__
            ));
        }

        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return decimal
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param decimal $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string|null
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string|null $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return decimal
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param decimal $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return decimal
     */
    public function getAmount()
    {
        return bcmul($this->quantity, $this->unitPrice, 2);
    }
}
