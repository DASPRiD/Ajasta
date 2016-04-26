<?php
declare(strict_types=1);

namespace Ajasta\Domain;

use Ajasta\Domain\Exception\InvalidVatPercentage;

final class VatPercentage
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
        if (!preg_match('^\d*(?:\.\d*)$', $value)) {
            throw InvalidVatPercentage::fromInvalidNumber($value);
        }

        if (-1 === bccomp($value, '0')) {
            throw InvalidVatPercentage::fromNegativeNumber($value);
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
