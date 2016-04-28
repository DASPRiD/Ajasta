<?php
declare(strict_types=1);

namespace Ajasta\Domain;

final class Descriptor
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
        $trimmedValue = trim($value);

        if ('' === $trimmedValue) {
            throw Exception\InvalidDescriptor::fromBlankDescriptor();
        }

        return new self($trimmedValue);
    }

    public function __toString() : string
    {
        return $this->value;
    }
}
