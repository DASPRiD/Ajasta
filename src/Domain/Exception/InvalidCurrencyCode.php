<?php
declare(strict_types=1);

namespace Ajasta\Domain\Exception;

use DomainException;

class InvalidCurrencyCode extends DomainException implements ExceptionInterface
{
    public static function fromInvalidCurrencyCode(string $currencyCode) : self
    {
        return new self(sprintf('Invalid currency code "%s" provided', $currencyCode));
    }
}
