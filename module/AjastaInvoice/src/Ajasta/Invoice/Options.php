<?php
namespace Ajasta\Invoice;

use InvalidArgumentException;
use Zend\Stdlib\AbstractOptions;

class Options extends AbstractOptions
{
    /**
     * @var string
     */
    protected $defaultVat = '0.0';

    /**
     * @var string|null
     */
    protected $defaultUnit;

    /**
     * @var string
     */
    protected $defaultUnitPrice = '0.0';

    /**
     * @var string
     */
    protected $invoiceNumberFormat = '%1$s';

    /**
     * @return string
     */
    public function getDefaultVat()
    {
        return $this->defaultVat;
    }

    /**
     * @param string $defaultVat
     */
    public function setDefaultVat($defaultVat)
    {
        if (!is_string($defaultVat) || !preg_match('(^\d+(\.\d+)?$)', $defaultVat)) {
            throw new InvalidArgumentException(sprintf(
                'Default VAT must be a decimal string value, got %s',
                $defaultVat
            ));
        }

        $this->defaultVat = $defaultVat;
    }

    /**
     * @return string|null
     */
    public function getDefaultUnit()
    {
        return $this->defaultUnit;
    }

    /**
     * @param string|null $defaultUnit
     */
    public function setDefaultUnit($defaultUnit)
    {
        if (!in_array($defaultUnit, [null, 'hours', 'days'], true)) {
            throw new InvalidArgumentException(sprintf(
                'Default unit must be either null, "hours" or "days", got %s',
                $defaultUnit
            ));
        }

        $this->defaultUnit = $defaultUnit;
    }

    /**
     * @return string|null
     */
    public function getDefaultUnitPrice()
    {
        return $this->defaultUnitPrice;
    }

    /**
     * @param string $defaultUnitPrice
     */
    public function setDefaultUnitPrice($defaultUnitPrice)
    {
        if (!is_string($defaultUnitPrice) || !preg_match('(^\d+(\.\d+)?$)', $defaultUnitPrice)) {
            throw new InvalidArgumentException(sprintf(
                'Default unit price must be a decimal string value, got %s',
                $defaultUnitPrice
            ));
        }

        $this->defaultUnitPrice = $defaultUnitPrice;
    }

    /**
     * @return string
     */
    public function getInvoiceNumberFormat()
    {
        return $this->invoiceNumberFormat;
    }

    /**
     * @param string $invoiceNumberFormat
     */
    public function setInvoiceNumberFormat($invoiceNumberFormat)
    {
        if (!is_string($invoiceNumberFormat)) {
            throw new InvalidArgumentException(sprintf(
                'Invoice number format must be a string, got %s',
                is_object($invoiceNumberFormat) ? get_class($invoiceNumberFormat) : gettype($invoiceNumberFormat)
            ));
        }

        $this->invoiceNumberFormat = $invoiceNumberFormat;
    }
}
