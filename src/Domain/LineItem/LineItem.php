<?php
namespace Ajasta\Domain\LineItem;

use Ajasta\Domain\Descriptor;
use Ajasta\Domain\Price;
use Ajasta\Domain\Unit;

final class LineItem
{
    /**
     * @var LineItemId
     */
    private $lineItemId;

    /**
     * @var Descriptor
     */
    private $description;

    /**
     * @var Quantity
     */
    private $quantity;

    /**
     * @var Unit
     */
    private $unit;

    /**
     * @var Price
     */
    private $unitPrice;

    private function __construct()
    {
        $this->lineItemId = LineItemId::newLineItemId();
    }

    public static function newLineItem(Descriptor $description, Quantity $quantity, Unit $unit, Price $unitPrice)
    {
        $lineItem = new self();
        $lineItem->description = $description;
        $lineItem->quantity = $quantity;
        $lineItem->unit = $unit;
        $lineItem->unitPrice = $unitPrice;

        return $lineItem;
    }

    public function getDescription() : Descriptor
    {
        return $this->description;
    }

    public function getQuantity() : Quantity
    {
        return $this->quantity;
    }

    public function getUnit() : Unit
    {
        return $this->unit;
    }

    public function getUnitPrice() : Price
    {
        return $this->unitPrice;
    }
}
