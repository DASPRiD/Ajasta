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
     * @param  string      $currencyCode
     * @param  string|null $locale
     * @return string
     * @throws InvalidArgumentException
     */
    public function lookupCurrencyName($currencyCode, $locale = null)
    {
        if (!preg_match('(^[A-Z]{3}$)', $currencyCode)) {
            throw new InvalidArgumentException('Invalid currency code given');
        }

        return $this->lookupNames(
            '/ldml/numbers/currencies/currency[@type="' . $currencyCode . '"]/displayName[not(@count)]',
            $currencyCode,
            $locale
        );
    }

    /**
     * @param  string      $countryCode
     * @param  string|null $locale
     * @return string
     * @throws InvalidArgumentException
     */
    public function lookupCountryName($countryCode, $locale = null)
    {
        if (!preg_match('(^[A-Z]{2}$)', $countryCode)) {
            throw new InvalidArgumentException('Invalid country code given');
        }

        return $this->lookupNames(
            '/ldml/localeDisplayNames/territories/territory[@type="' . $countryCode . '"]',
            $countryCode,
            $locale
        );
    }

    /**
     * @param  string      $path
     * @param  string      $fallback
     * @param  string|null $locale
     * @return string
     */
    protected function lookupNames($path, $fallback, $locale = null)
    {
        $locale = $locale ?: Locale::getDefault();

        $names = $this->reader->getPathData(
            $locale,
            $path,
            '',
            'value'
        );

        if (!isset($names['value'])) {
            return $fallback;
        }

        return $names['value'];
    }
}
