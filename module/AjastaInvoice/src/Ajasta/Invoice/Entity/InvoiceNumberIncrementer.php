<?php
namespace Ajasta\Invoice\Entity;

class InvoiceNumberIncrementer
{
    const ID = 1;

    /**
     * @var int
     */
    protected $id = self::ID;

    /**
     * @var int
     */
    protected $value = 1;

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    public function incrementValue()
    {
        $this->value++;
    }
}
