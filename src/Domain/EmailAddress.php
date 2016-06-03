<?php
declare(strict_types=1);

namespace Ajasta\Domain;

use Ajasta\Domain\Exception\InvalidEmailAddress;
use Zend\Validator\EmailAddress as EmailAddressValidator;

final class EmailAddress
{
    /**
     * @var string
     */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value) : self
    {
        if (!(new EmailAddressValidator())->isValid($value)) {
            throw InvalidEmailAddress::fromInvalidEmailAddress($value);
        }

        return new self($value);
    }

    public function __toString() : string
    {
        return $this->value;
    }
}
