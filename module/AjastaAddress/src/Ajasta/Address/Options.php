<?php
namespace Ajasta\Address;

use InvalidArgumentException;
use Zend\Stdlib\AbstractOptions;

class Options extends AbstractOptions
{
    /**
     * @var string
     */
    protected $localeDataUri = 'http://i18napis.appspot.com/address/data';

    /**
     * @var string
     */
    protected $dataPath;

    /**
     * @var string
     */
    protected $countryCodesPath;

    public function __construct($options = null)
    {
        $this->dataPath         = __DIR__ . '/../../../data';
        $this->countryCodesPath = __DIR__ . '/../../../data/country-codes.php';

        parent::__construct($options);
    }

    /**
     * @return string
     */
    public function getLocaleDataUri()
    {
        return $this->localeDataUri;
    }

    /**
     * @param string $localeDataUri
     */
    public function setLocaleDataUri($localeDataUri)
    {
        $this->localeDataUri = $localeDataUri;
    }

    /**
     * @return string
     */
    public function getDataPath()
    {
        return $this->dataPath;
    }

    /**
     * @param string $dataPath
     */
    public function setDataPath($dataPath)
    {
        if (!is_dir($dataPath)) {
            throw new InvalidArgumentException('Data path is not a directory');
        }

        $this->dataPath = rtrim($dataPath, '/');
    }

    /**
     * @return string
     */
    public function getCountryCodesPath()
    {
        return $this->countryCodesPath;
    }

    /**
     * @param string $countryCodesPath
     */
    public function setCountryCodesPath($countryCodesPath)
    {
        $this->countryCodesPath = $countryCodesPath;
    }
}