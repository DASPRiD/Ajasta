<?php
declare(strict_types=1);

namespace Ajasta\Domain\Exception;

use DomainException;

class InvalidEmailAddress extends DomainException implements ExceptionInterface
{
    public static function fromInvalidEmailAddress(string $emailAddress) : self
    {
        return new self(sprintf('Invalid email address "%s" provided', $emailAddress));
    }
}
