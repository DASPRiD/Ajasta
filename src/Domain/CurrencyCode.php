<?php
declare(strict_types=1);

namespace Ajasta\Domain;

use Ajasta\Domain\Exception\InvalidCurrencyCode;

final class CurrencyCode
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
        if (!preg_match('^[a-z]{3}$', $value)) {
            throw InvalidCurrencyCode::fromInvalidCurrencyCode($value);
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
