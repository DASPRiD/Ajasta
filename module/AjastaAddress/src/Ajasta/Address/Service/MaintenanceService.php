<?php
namespace Ajasta\Address\Service;

use Ajasta\Address\Options;
use Zend\Config\Writer\PhpArray as PhpArrayWriter;
use Zend\Http\Client as HttpClient;
use Zend\ProgressBar\ProgressBar;
use Zend\ProgressBar\Adapter\AbstractAdapter as ProgressAdapter;

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

    /**
     * @param ProgressAdapter $progressAdapter
     */
    public function updateAddressFormats(ProgressAdapter $progressAdapter = null)
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

            if ($progressAdapter !== null) {
                $progressBar = new ProgressBar($progressAdapter, 0, count($countryCodes));
            }

            foreach ($countryCodes as $countryCode) {
                file_put_contents(
                    $dataPath . '/' . $countryCode . '.json',
                    $this->httpClient->setUri($localeDataUri . '/' . $countryCode)->send()->getContent()
                );

                if (isset($progressBar)) {
                    $progressBar->next();
                }
            }
        } else {
            $countryCodes = [];
        }

        if (isset($progressBar)) {
            $progressBar->finish();
        }

        // We clearly don't want the "ZZ" in the array!
        array_pop($countryCodes);

        $writer = new PhpArrayWriter();
        $writer->setUseBracketArraySyntax(true);
        $writer->toFile($this->options->getCountryCodesPath(), $countryCodes, false);
    }
}
