<?php
namespace Ajasta\Core\Form\Element;

use Ajasta\I18n\Cldr\Manager as CldrManager;
use Collator;
use Locale;
use Zend\Form\Element\Select;

class CurrencySelect extends Select
{
    /**
     * @var CldrManager
     */
    protected $cldrManager;

    /**
     * @var array|null
     */
    protected $valueOptions = null;

    /**
     * List of most common currency codes, these will be listed at the top in
     * the given order.
     *
     * @var array
     */
    protected static $commonCurrencyCodes = [
        'USD', 'EUR', 'JPY', 'GBP', 'CHF', 'CAD',
    ];

    /**
     * All remaining supported currency codes, which will be sorted
     * alphabetically by their display na,e.
     *
     * @var array
     */
    protected static $remainingCurrencyCodes = [
        'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN',
        'BAM', 'BBD', 'BDT', 'BGN', 'BHD', 'BIF', 'BMD', 'BND', 'BOB', 'BRL',
        'BSD', 'BTN', 'BWP', 'BYR', 'BZD', 'CDF', 'CLP', 'CNY', 'COP', 'CRC',
        'CUC', 'CUP', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ERN',
        'ETB', 'FJD', 'FKP', 'GEL', 'GGP', 'GHS', 'GIP', 'GMD', 'GNF', 'GTQ',
        'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'IMP', 'INR',
        'IQD', 'IRR', 'ISK', 'JEP', 'JMD', 'JOD', 'KES', 'KGS', 'KHR', 'KMF',
        'KPW', 'KRW', 'KWD', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL',
        'LTL', 'LYD', 'MAD', 'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MRO',
        'MUR', 'MVR', 'MWK', 'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK',
        'NPR', 'NZD', 'OMR', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG',
        'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SDG', 'SEK',
        'SGD', 'SHP', 'SLL', 'SOS', 'SPL', 'SRD', 'STD', 'SVC', 'SYP', 'SZL',
        'THB', 'TJS', 'TMT', 'TND', 'TOP', 'TRY', 'TTD', 'TVD', 'TWD', 'TZS',
        'UAH', 'UGX', 'UYU', 'UZS', 'VEF', 'VND', 'VUV', 'WST', 'XAF', 'XCD',
        'XDR', 'XOF', 'XPF', 'YER', 'ZAR', 'ZMW',
    ];

    /**
     * @param CldrManager $cldrManager
     */
    public function __construct(CldrManager $cldrManager)
    {
        $this->cldrManager = $cldrManager;

        parent::__construct();
    }

    /**
     * @return array
     */
    public function getValueOptions()
    {
        if ($this->valueOptions !== null) {
            return $this->valueOptions;
        }

        $this->setValueOptions(static::getCurrencyValueOptions($this->cldrManager));

        return $this->valueOptions;
    }

    /**
     * @param  CldrManager $cldrManager
     * @return array
     */
    protected static function getCurrencyValueOptions(CldrManager $cldrManager)
    {
        $commonCurrencies    = [];
        $remainingCurrencies = [];

        foreach (static::$commonCurrencyCodes as $currencyCode) {
            $commonCurrencies[$currencyCode] = $cldrManager->lookupCurrencyName($currencyCode);
        }

        foreach (static::$remainingCurrencyCodes as $currencyCode) {
            $remainingCurrencies[$currencyCode] = $cldrManager->lookupCurrencyName($currencyCode);
        }

        $collator = new Collator(Locale::getDefault());
        $collator->asort($remainingCurrencies);

        return [
            [
                'label' => 'Common currencies',
                'options' => $commonCurrencies,
            ],
            [
                'label' => 'Remamining Currencies',
                'options' => $remainingCurrencies,
            ],
        ];
    }
}
