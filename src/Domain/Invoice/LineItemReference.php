<?php
declare(strict_types=1);

namespace Ajasta\Domain\Invoice;

use Ajasta\Domain\LineItem\LineItem;

final class LineItemReference
{
    /**
     * @var int
     */
    private $position;

    /**
     * @var LineItem
     */
    private $lineItem;

    public function __construct(int $position, LineItem $lineItem)
    {
        $this->position = $position;
        $this->lineItem = $lineItem;
    }

    public function getPosition() : int
    {
        return $this->position;
    }

    public function getLineItem() : LineItem
    {
        return $this->lineItem;
    }
}
