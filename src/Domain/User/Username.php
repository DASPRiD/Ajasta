<?php
declare(strict_types = 1);

namespace Ajasta\Domain\User;

final class Username
{
    /**
     * @var string
     */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString($value) : self
    {
        return new self($value);
    }

    public function __toString() : string
    {
        return $this->value;
    }
}
