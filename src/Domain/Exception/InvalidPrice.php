<?php
declare(strict_types=1);

namespace Ajasta\Domain\Exception;

use DomainException;

class InvalidPrice extends DomainException implements ExceptionInterface
{
    public static function fromInvalidNumber(string $number) : self
    {
        return new self(sprintf('Invalid number "%s" provided', $number));
    }

    public static function fromNegativeNumber(string $number) : self
    {
        return new self(sprintf('Invalid negative number "%s" provided', $number));
    }
}
