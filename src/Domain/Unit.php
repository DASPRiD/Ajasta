<?php
declare(strict_types=1);

namespace Ajasta\Domain;

use Ajasta\Domain\Exception\InvalidUnit;

final class Unit
{
    const UNIT_NONE = 'none';
    const UNIT_HOURS = 'hours';
    const UNIT_DAYS = 'days';

    const ALLOWED_UNITS = [
        self::UNIT_NONE,
        self::UNIT_HOURS,
        self::UNIT_DAYS,
    ];

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
        if (!in_array($value, self::ALLOWED_UNITS, true)) {
            throw InvalidUnit::fromInvalidUnit($value);
        }

        return new self($value);
    }

    public function __toString() : string
    {
        return $this->value;
    }
}
