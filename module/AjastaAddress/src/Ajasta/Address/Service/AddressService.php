<?php
namespace Ajasta\Address\Service;

use Ajasta\Address\Entity\Address;
use Ajasta\Address\Options;
use RuntimeException;

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
     * @var Options
     */
    protected $options;

    /**
     * @var string[]|null
     */
    protected $countryCodes;

    /**
     * @var bool[]
     */
    protected $fieldCache = [];

    /**
     * @param Options $options
     */
    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    /**
     * @param  Address $address
     * @param  bool    $addCountry
     * @return string[]
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

        if ($addCountry && $countryCode !== 'ZZ') {
            $lines[] = $this->getJsonValue($countryCode, 'name');
        }

        return $lines;
    }

    /**
     * @return bool[]
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
     * @return string[]
     */
    public function getCountryCodes()
    {
        if ($this->countryCodes !== null) {
            return $this->countryCodes;
        }

        return ($this->countryCodes = require $this->options->getCountryCodesPath());
    }

    /**
     * @param  string $countryCode
     * @return string[]
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
        if (!in_array($countryCode, $this->getCountryCodes()) && $countryCode !== 'ZZ') {
            return null;
        }

        $filename = $this->options->getDataPath() . '/' . $countryCode . '.json';

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
