<?php
declare(strict_types=1);

namespace Ajasta\Domain;

use Ajasta\Domain\Exception\InvalidLocale;

final class Locale
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
        if (!preg_match('^[a-z]{2}-[a-z]{2}$', $value)) {
            throw InvalidLocale::fromInvalidLocale($value);
        }

        return new self($value);
    }

    public function __toString() : string
    {
        return $this->value;
    }
}
