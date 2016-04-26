<?php
declare(strict_types=1);

namespace Ajasta\Domain\Exception;

use DomainException;

class InvalidUnit extends DomainException implements ExceptionInterface
{
    public static function fromInvalidUnit(string $unit) : self
    {
        return new self(sprintf('Invalid unit "%s" provided', $unit));
    }
}
