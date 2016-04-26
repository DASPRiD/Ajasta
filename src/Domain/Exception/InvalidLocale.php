<?php
declare(strict_types=1);

namespace Ajasta\Domain\Exception;

use DomainException;

class InvalidLocale extends DomainException implements ExceptionInterface
{
    public static function fromInvalidLocale(string $locale) : self
    {
        return new self(sprintf('Invalid locale "%s" provided', $locale));
    }
}
