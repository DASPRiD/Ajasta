<?php
namespace Application\Form\Element;

use Application\I18n\CurrencyInformation;
use Collator;
use Locale;
use Zend\Form\Element\Select;

class CurrencySelect extends Select
{
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

    public function __construct(CurrencyInformation $currencyInformation)
    {
        parent::__construct(null, []);

        $this->setValueOptions(static::getCurrencyValueOptions($currencyInformation));
    }

    /**
     * @return array
     */
    protected static function getCurrencyValueOptions(CurrencyInformation $currencyInformation)
    {
        $commonCurrencies    = [];
        $remainingCurrencies = [];

        foreach (static::$commonCurrencyCodes as $currencyCode) {
            $commonCurrencies[$currencyCode] = $currencyInformation->getCurrencyName($currencyCode);
        }

        foreach (static::$remainingCurrencyCodes as $currencyCode) {
            $remainingCurrencies[$currencyCode] = $currencyInformation->getCurrencyName($currencyCode);
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
