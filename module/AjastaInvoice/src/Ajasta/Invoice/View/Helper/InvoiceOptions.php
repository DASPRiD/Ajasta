<?php
namespace Ajasta\Invoice\View\Helper;

use Zend\View\Helper\AbstractHelper;

class InvoiceOptions extends AbstractHelper
{
    /**
     * @var decimal
     */
    protected $defaultVat;

    /**
     * @var string|null
     */
    protected $defaultUnit;

    /**
     * @var decimal
     */
    protected $defaultUnitPrice;

    /**
     * @param decimal     $defaultVat
     * @param string|null $defaultUnit
     * @param decimal     $defaultUnitPrice
     */
    public function __construct($defaultVat, $defaultUnit, $defaultUnitPrice)
    {
        $this->defaultVat       = $defaultVat;
        $this->defaultUnit      = $defaultUnit;
        $this->defaultUnitPrice = $defaultUnitPrice;
    }

    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'defaultVat'       => $this->defaultVat,
            'defaultUnit'      => $this->defaultUnit,
            'defaultUnitPrice' => $this->defaultUnitPrice,
        ];
    }
}
