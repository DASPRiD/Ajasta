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
            throw new InvalidArgumentException(sprintf(
                'Invalid currency code "%s"',
                $currencyCode
            ));
        }

        return $this->lookupName(
            '/ldml/numbers/currencies/currency[@type="' . $currencyCode . '"]/displayName[not(@count)]',
            $currencyCode,
            $locale ?: Locale::getDefault()
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
            throw new InvalidArgumentException(sprintf(
                'Invalid country code "%s"',
                $countryCode
            ));
        }

        return $this->lookupName(
            '/ldml/localeDisplayNames/territories/territory[@type="' . $countryCode . '"]',
            $countryCode,
            $locale ?: Locale::getDefault()
        );
    }

    /**
     * @param  string      $unit
     * @param  string      $length
     * @param  string|null $locale
     * @return string[]
     * @throws InvalidArgumentException
     */
    public function getUnitForms($unit, $length, $locale = null)
    {
        $units = $this->reader->getPathData(
            $locale ?: Locale::getDefault(),
            '/ldml/units/unitLength[@type="' . $length . '"]/unit[@type="' . $unit . '"]/unitPattern',
            'count'
        );

        if (!$units) {
            throw new InvalidArgumentException(sprintf(
                'No units found for length "%s" and unit "%s"',
                $length,
                $unit
            ));
        }

        return $units;
    }

    /**
     * @param  string $path
     * @param  string $fallback
     * @param  string $locale
     * @return string
     */
    protected function lookupName($path, $fallback, $locale)
    {
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
