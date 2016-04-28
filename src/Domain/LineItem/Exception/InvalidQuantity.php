<?php
declare(strict_types=1);

namespace Ajasta\Domain\LineItem\Exception;

use DomainException;

class InvalidQuantity extends DomainException implements ExceptionInterface
{
    public static function fromNonPositiveNumber(int $number) : self
    {
        return new self(sprintf('Invalid number "%s" smaller than 1 provided', $number));
    }
}
