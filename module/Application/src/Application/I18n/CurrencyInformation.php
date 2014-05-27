<?php
namespace Application\I18n;

use Locale;
use RuntimeException;

class CurrencyInformation
{
    /**
     * @var string
     */
    protected $cldrPath;

    /**
     * @var array
     */
    protected $xmlCache = [];

    /**
     * @param string $cldrPath
     */
    public function __construct($cldrPath)
    {
        $this->cldrPath = rtrim($cldrPath, '/');
    }

    /**
     * @param  strnig $currencyCode
     * @param  string $locale
     * @return string
     */
    public function getCurrencyName($currencyCode, $locale = null)
    {
        if (!preg_match('(^[A-Z]{3}$)', $currencyCode)) {
            throw new RuntimeException('Invalid currency code given');
        }

        if ($locale === null) {
            $locale = Locale::getDefault();
        }

        $language = Locale::getPrimaryLanguage($locale);
        $region   = Locale::getRegion($locale);

        $primaryFile  = $this->cldrPath . '/' . $language . '_' . $region . '.xml';
        $fallbackFile = $this->cldrPath . '/' . $language . '.xml';

        if (null !== ($currencyName = $this->queryCurrencyName($primaryFile, $currencyCode))) {
            return $currencyName;
        }

        if (null !== ($currencyName = $this->queryCurrencyName($fallbackFile, $currencyCode))) {
            return $currencyName;
        }

        return $currencyCode;
    }

    /**
     * @param  string  $file
     * @param  string $currencyCode
     * @return string|null
     */
    protected function queryCurrencyName($file, $currencyCode)
    {
        if (!isset($this->xmlCache[$file])) {
            if (!file_exists($file)) {
                $this->xmlCache[$file] = false;
                return null;
            }

            $this->xmlCache[$file] = simplexml_load_file($file);
        }

        if ($this->xmlCache[$file] === false) {
            return null;
        }

        $displayNames = $this->xmlCache[$file]->xpath('./numbers/currencies/currency[@type="' . $currencyCode . '"]/displayName[not(@count)]');

        if (!count($displayNames)) {
            return null;
        }

        return (string) $displayNames[0];
    }
}
