<?php
namespace Ajasta\I18n\Cldr;

use InvalidArgumentException;
use Locale;

class Manager
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Looks up a currency name from a currency code.
     *
     * @param  string $currencyCode
     * @param  string $locale
     * @return string
     * @throws InvalidArgumentException
     */
    public function lookupCurrencyName($currencyCode, $locale = null)
    {
        $locale = $locale ?: Locale::getDefault();

        if (!preg_match('(^[A-Z]{3}$)', $currencyCode)) {
            throw new InvalidArgumentException('Invalid currency code given');
        }

        $names = $this->reader->getPathData($locale, '/ldml/numbers/currencies/currency[@type="' . $currencyCode . '"]/displayName[not(@count)]', '', $currencyCode);

        if (!isset($names[$currencyCode])) {
            return $currencyCode;
        }

        return $names[$currencyCode];
    }
}
