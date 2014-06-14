<?php
namespace Ajasta\AddressTest\Service;

use Ajasta\Address\Options;
use Ajasta\Address\Service\MaintenanceService;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Http\Client as HttpClient;
use Zend\Http\Client\Adapter\Test as HttpTestAdapter;
use Zend\Http\Response as HttpResponse;

/**
 * @coversDefaultClass Ajasta\Address\Service\MaintenanceService
 * @covers ::<!public>
 * @covers ::__construct
 */
class MaintenanceServiceTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    protected $root;

    /**
     * @var Options
     */
    protected $options;

    public function setUp()
    {
        $this->root = vfsStream::setup();

        $this->options = new Options([
            'locale_data_uri'    => 'http://example.com/data',
            'data_path'          => $this->root->url(),
            'country_codes_path' => $this->root->url() . '/country-codes.php',
        ]);
    }

    /**
     * @covers ::updateAddressFormats
     */
    public function testUpdateAddressFormatsRemovesLegacyFiles()
    {
        $this->root->addChild(new vfsStreamFile('legacy.json'));

        $httpClient = new HttpClient();
        $httpClient->setAdapter(new HttpTestAdapter());

        $maintenanceService = new MaintenanceService($this->options, $httpClient);
        $maintenanceService->updateAddressFormats();

        $this->assertFalse($this->root->hasChild('legacy.json'));
    }

    /**
     * @covers ::updateAddressFormats
     */
    public function testUpdateAddressFormatsIgnoresInvalidResponse()
    {
        $httpClient = new HttpClient();
        $httpClient->setAdapter(new HttpTestAdapter());

        $maintenanceService = new MaintenanceService($this->options, $httpClient);
        $maintenanceService->updateAddressFormats();

        $this->assertSame([], include $this->root->url() . '/country-codes.php');
    }

    /**
     * @covers ::updateAddressFormats
     */
    public function testUpdateAddressFormatsStoresAllData()
    {
        $testAdapter = new HttpTestAdapter();
        $testAdapter->setResponse([
            (new HttpResponse())->setContent('{"countries": "US~UK"}'),
            (new HttpResponse())->setContent('{"name": "US"}'),
            (new HttpResponse())->setContent('{"name": "UK"}'),
            (new HttpResponse())->setContent('{"name": "ZZ"}'),
        ]);
        $httpClient = new HttpClient();
        $httpClient->setAdapter($testAdapter);

        $maintenanceService = new MaintenanceService($this->options, $httpClient);
        $maintenanceService->updateAddressFormats();

        $this->assertSame(['US', 'UK'], include $this->root->url() . '/country-codes.php');
        $this->assertSame('{"name": "US"}', file_get_contents($this->root->url() . '/US.json'));
        $this->assertSame('{"name": "UK"}', file_get_contents($this->root->url() . '/UK.json'));
        $this->assertSame('{"name": "ZZ"}', file_get_contents($this->root->url() . '/ZZ.json'));
    }

    /**
        $localeDataDirectory = new vfsStreamDirectory('locale_data');
        $localeDataDirectory->addChild(
            (new vfsStreamFile('US.json'))->withContent(
                '{"fmt": "%N%n%O%n%A%n%C %S %Z", "require": "ACSZ" "name": "UNITED STATES"}'
            )
        );
     */
}
