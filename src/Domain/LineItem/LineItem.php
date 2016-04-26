<?php
namespace Ajasta\Domain\LineItem;

use Ajasta\Domain\Price;
use Ajasta\Domain\Unit;

final class LineItem
{
    /**
     * @var LineItemId
     */
    private $lineItemId;

    /**
     * @var Position
     */
    private $position;

    /**
     * @var string
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

    /**
     * @param Position $position
     * @param string $description
     * @param Quantity $quantity
     * @param Unit $unit
     * @param Price $unitPrice
     */
    public static function newLineItem($position, $description, $quantity, $unit, $unitPrice)
    {
        $lineItem = new self();
        $lineItem->position = $position;
        $lineItem->description = $description;
        $lineItem->quantity = $quantity;
        $lineItem->unit = $unit;
        $lineItem->unitPrice = $unitPrice;

        return $lineItem;
    }

    public function getDescription() : string
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
