<?php
namespace Application\View\Helper;

use Application\I18n\CurrencyInformation;
use Zend\View\Helper\AbstractHelper;

class DisplayCurrency extends AbstractHelper
{
    /**
     * @var CurrencyInformation
     */
    protected $currencyInformation;

    public function __construct(CurrencyInformation $currencyInformation)
    {
        $this->currencyInformation = $currencyInformation;
    }

    public function __invoke($currencyCode)
    {
        return $this->currencyInformation->getCurrencyName($currencyCode);
    }
}
