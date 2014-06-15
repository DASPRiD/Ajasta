<?php
namespace Ajasta\Invoice\Entity;

use Ajasta\Core\EntityUtils;

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
     * @var string
     */
    protected $quantity;

    /**
     * @var string|null
     */
    protected $unit;

    /**
     * @var string
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
        EntityUtils::restrictCaller('Ajasta\Invoice\Entity\Invoice');
        $this->invoice = $invoice;
    }

    /**
     * @internal
     * @param int $position
     */
    public function setPosition($position)
    {
        EntityUtils::restrictCaller('Ajasta\Invoice\Entity\Invoice');
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
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
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
     * @return string
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param string $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return bcmul($this->quantity, $this->unitPrice, 2);
    }
}
