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

    private function __construct()
    {
    }

    public static function fromString(string $value) : self
    {
        if (!preg_match('^[a-z]{2}-[a-z]{2}$', $value)) {
            throw InvalidLocale::fromInvalidLocale($value);
        }

        $instance = new self();
        $instance->value = $value;

        return $instance;
    }

    public function __toString() : string
    {
        return $this->value;
    }
}
