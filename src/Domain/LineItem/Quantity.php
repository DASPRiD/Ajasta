<?php
declare(strict_types=1);

namespace Ajasta\Domain\LineItem;

use Ajasta\Domain\LineItem\Exception\InvalidQuantity;

final class Quantity
{
    /**
     * @var int
     */
    private $value;

    private function __construct(int $value)
    {
        $this->value = $value;
    }

    public static function fromInteger(int $value) : self
    {
        if ($value < 1) {
            throw InvalidQuantity::fromNonPositiveNumber($value);
        }

        return new self($value);
    }

    public function toInt() : int
    {
        return $this->value;
    }
}
