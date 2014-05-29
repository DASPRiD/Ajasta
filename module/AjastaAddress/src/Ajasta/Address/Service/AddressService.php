<?php
namespace Ajasta\Address\Service;

use Ajasta\Address\Entity\Address;
use RuntimeException;
use Zend\Config\Writer\PhpArray as PhpArrayWriter;

class AddressService
{
    /**
     * @var array
     */
    protected static $fieldMap = [
        'S' => 'administrativeArea',
        'C' => 'locality',
        'N' => 'recipient',
        'O' => 'organization',
        '1' => 'addressLine1',
        '2' => 'addressLine2',
        'D' => 'dependentLocality',
        'Z' => 'postalCode',
        'X' => 'sortingCode',
    ];

    /**
     * @var string
     */
    protected $dataPath;

    /**
     * @var string
     */
    protected $localeDataUri;

    /**
     * @var array
     */
    protected $countryCodes;

    /**
     * @var array
     */
    protected $fieldCache = [];

    /**
     * @param string $dataPath
     * @param string $localeDataUri
     * @param array  $countryCodes
     */
    public function __construct($dataPath, $localeDataUri, array $countryCodes)
    {
        $this->dataPath      = rtrim($dataPath, '/');
        $this->localeDataUri = $localeDataUri;
        $this->countryCodes  = $countryCodes;
    }

    /**
     * @param  Address $address
     * @param  bool    $addCountry
     * @return array
     */
    public function formatAddress(Address $address, $addCountry = true)
    {
        $countryCode = $address->getCountryCode();
        $lines       = [];
        $currentLine = '';

        foreach ($this->getFormatSubStrings($countryCode) as $part) {
            if ($part === "\n") {
                $normalizedLine = $this->removeAllRedundantSpaces($currentLine);

                if (strlen($normalizedLine) > 0) {
                    $lines[] = $normalizedLine;
                }

                $currentLine = '';
                continue;
            }

            if ($part[0] === '%') {
                $flag  = $part[1];
                $field = static::$fieldMap[$flag];
                $value = $address->{'get' . ucfirst($field)}();

                if ($value !== null) {
                    $currentLine .= $value;
                }
                continue;
            }

            $currentLine .= $part;
        }

        $normalizedLine = $this->removeAllRedundantSpaces($currentLine);

        if (strlen($normalizedLine) > 0) {
            $lines[] = $normalizedLine;
        }

        if ($addCountry) {
            $lines[] = $this->getJsonValue($countryCode, 'name');
        }

        return $lines;
    }

    /**
     * @return array
     */
    public function getFieldsForCountry($countryCode)
    {
        if (isset($this->fieldCache[$countryCode])) {
            return $this->fieldCache[$countryCode];
        }

        $format        = $this->getJsonValue($countryCode, 'fmt') ?: $this->getJsonValue('ZZ', 'fmt');
        $requiredFlags = $this->getJsonValue($countryCode, 'require') ?: $this->getJsonValue('ZZ', 'require');
        $matches       = [];
        $fields        = [];

        preg_match_all('(%([SCNO12DZXA]))', $format, $matches);

        foreach ($matches[1] as $flag) {
            $required = (strpos($requiredFlags, $flag) !== false);

            if ($flag === 'A') {
                // Deprecated flag, we have to map it
                $fields[static::$fieldMap['1']] = $required;
                $fields[static::$fieldMap['2']] = false;
                continue;
            }

            $fields[static::$fieldMap[$flag]] = $required;
        }

        return ($this->fieldCache[$countryCode] = $fields);
    }

    /**
     * @return array
     */
    public function getCountryCodes()
    {
        return $this->countryCodes;
    }

    /**
     * This is a maintenance method for development only.
     */
    public function updateAddressFormats()
    {
        $locales = json_decode(file_get_contents($this->localeDataUri));

        foreach (glob($this->dataPath . '/*.json') as $file) {
            unlink($file);
        }

        if (isset($locales->countries)) {
            $countryCodes = explode('~', $locales->countries);
            $countryCodes[] = 'ZZ';

            foreach ($countryCodes as $countryCode) {
                file_put_contents(
                    $this->dataPath . '/' . $countryCode . '.json',
                    file_get_contents($this->localeDataUri . '/' . $countryCode)
                );
            }
        } else {
            $countryCodes = [];
        }

        // We clearly don't want the "ZZ" in the array!
        array_pop($countryCodes);

        $writer = new PhpArrayWriter();
        $writer->setUseBracketArraySyntax(true);
        $writer->toFile($this->dataPath . '/country-codes.php', $countryCodes);
    }

    /**
     * @param  string $countryCode
     * @return array
     * @throws RuntimeException
     */
    protected function getFormatSubStrings($countryCode)
    {
        $format = $this->getJsonValue($countryCode, 'fmt') ?: $this->getJsonValue('ZZ', 'fmt');
        $parts  = [];

        $escaped = false;
        $length  = strlen($format);

        for ($index = 0; $index < $length; $index++) {
            $char = $format[$index];

            if ($escaped) {
                $escaped = false;

                if ($char === 'n') {
                    $parts[] = "\n";
                    continue;
                }

                if ($char === 'A') {
                    $parts[] = '%1';
                    $parts[] = "\n";
                    $parts[] = '%2';
                    continue;
                }

                if (!isset(static::$fieldMap[$char])) {
                    throw new RuntimeException(sprintf(
                        'Unrecognized character "%s" in format pattern "%s"',
                        $char,
                        $format
                    ));
                }

                $parts[] = '%' . $char;
                continue;
            }

            if ($char === '%') {
                $escaped = true;
                continue;
            }

            $parts[] = $char;
        }

        return $parts;
    }

    /**
     * @param  string $string
     * @return string
     */
    protected function removeAllRedundantSpaces($string)
    {
        return preg_replace('( +)', ' ', trim($string));
    }

    /**
     * @param  string $countryCode
     * @param  string $key
     * @return string|null
     */
    protected function getJsonValue($countryCode, $key)
    {
        if (!in_array($countryCode, $this->countryCodes) && $countryCode !== 'ZZ') {
            return null;
        }

        $filename = $this->dataPath . '/' . $countryCode . '.json';

        if (!file_exists($filename)) {
            return null;
        }

        $data = json_decode(file_get_contents($filename), true);

        if (!isset($data[$key])) {
            return null;
        }

        return $data[$key];
    }
}
