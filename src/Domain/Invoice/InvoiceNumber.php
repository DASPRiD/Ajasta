<?php
declare(strict_types=1);

namespace Ajasta\Domain\Invoice;

final class InvoiceNumber
{
    /**
     * @var string
     */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $value
     * @return InvoiceNumber
     */
    public static function fromString($value)
    {
        // @todo validation
        return new self($value);
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->value;
    }
}
