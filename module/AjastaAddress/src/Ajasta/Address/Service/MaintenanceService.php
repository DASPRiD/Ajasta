<?php
namespace Ajasta\Address\Service;

use Ajasta\Address\Options;
use Zend\Config\Writer\PhpArray as PhpArrayWriter;
use Zend\Http\Client as HttpClient;

class MaintenanceService
{
    /**
     * @var Options
     */
    protected $options;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @param Options    $options
     * @param HttpClient $httpClient
     */
    public function __construct(Options $options, HttpClient $httpClient)
    {
        $this->options    = $options;
        $this->httpClient = $httpClient;
    }

    public function updateAddressFormats()
    {
        $localeDataUri = $this->options->getLocaleDataUri();
        $dataPath      = $this->options->getDataPath();
        $locales       = json_decode($this->httpClient->setUri($localeDataUri)->send()->getContent());

        foreach (scandir($dataPath) as $file) {
            if (fnmatch('*.json', $file)) {
                unlink($dataPath . '/' . $file);
            }
        }

        if (isset($locales->countries)) {
            $countryCodes = explode('~', $locales->countries);
            $countryCodes[] = 'ZZ';

            foreach ($countryCodes as $countryCode) {
                file_put_contents(
                    $dataPath . '/' . $countryCode . '.json',
                    $this->httpClient->setUri($localeDataUri . '/' . $countryCode)->send()->getContent()
                );
            }
        } else {
            $countryCodes = [];
        }

        // We clearly don't want the "ZZ" in the array!
        array_pop($countryCodes);

        $writer = new PhpArrayWriter();
        $writer->setUseBracketArraySyntax(true);
        $writer->toFile($this->options->getCountryCodesPath(), $countryCodes, false);
    }
}
