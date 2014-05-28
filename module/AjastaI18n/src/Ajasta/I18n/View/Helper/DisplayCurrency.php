<?php
namespace Ajasta\I18n\View\Helper;

use Ajasta\I18n\Cldr\Manager as CldrManager;
use Zend\View\Helper\AbstractHelper;

class DisplayCurrency extends AbstractHelper
{
    /**
     * @var CurrencyInformation
     */
    protected $cldrManager;

    /**
     * @param CldrManager $cldrManager
     */
    public function __construct(CldrManager $cldrManager)
    {
        $this->cldrManager = $cldrManager;
    }

    /**
     * @param  string $currencyCode
     * @return string
     */
    public function __invoke($currencyCode)
    {
        return $this->cldrManager->lookupCurrencyName($currencyCode);
    }
}
