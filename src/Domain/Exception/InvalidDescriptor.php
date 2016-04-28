<?php
declare(strict_types=1);

namespace Ajasta\Domain\Exception;

use DomainException;

class InvalidDescriptor extends DomainException implements ExceptionInterface
{
    public static function fromBlankDescriptor() : self
    {
        return new self(sprintf('Blank descriptor provided'));
    }
}
