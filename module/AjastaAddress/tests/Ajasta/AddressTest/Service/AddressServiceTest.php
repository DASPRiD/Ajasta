<?php
namespace Ajasta\AddressTest\Service;

use Ajasta\Address\Entity\Address;
use Ajasta\Address\Options;
use Ajasta\Address\Service\AddressService;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit_Framework_TestCase as TestCase;
use ReflectionClass;

/**
 * @coversDefaultClass Ajasta\Address\Service\AddressService
 * @covers ::<!public>
 * @covers ::__construct
 */
class AddressServiceTest extends TestCase
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
        $this->root->addChild(
            (new vfsStreamFile('country-codes.php'))->withContent(
                '<' . '?php return ["US", "UK", "DE", "FR"];'
            )
        );
        $this->root->addChild(
            (new vfsStreamFile('US.json'))->withContent(
                '{"fmt": "%N%n%O%n%A%n%C %S %Z", "require": "ACSZ", "name": "UNITED STATES"}'
            )
        );
        $this->root->addChild(
            (new vfsStreamFile('ZZ.json'))->withContent(
                '{"fmt": "%N%n%O%n%A%n%C", "require": "AC"}'
            )
        );
        $this->root->addChild(
            (new vfsStreamFile('FR.json'))->withContent('{"fmt": "%]", "name": "FR"}')
        );
        $this->root->addChild(
            (new vfsStreamFile('DE.json'))->withContent('invalid-json')
        );

        $this->options = new Options([
            'data_path'          => $this->root->url(),
            'country_codes_path' => $this->root->url() . '/country-codes.php',
        ]);
    }

    /**
     * @covers ::formatAddress
     */
    public function testFormatAddressDefault()
    {
        $address = new Address();
        $address->setCountryCode('US');
        $address->setAddressLine1('foo street');
        $address->setLocality('bar');
        $address->setAdministrativeArea('CA');
        $address->setPostalCode('12345');

        $addressService = new AddressService($this->options);
        $this->assertSame(
            [
                'foo street',
                'bar CA 12345',
                'UNITED STATES',
            ],
            $addressService->formatAddress($address)
        );
    }

    /**
     * @covers ::formatAddress
     */
    public function testFormatAddressRemovesRedundantSpaces()
    {
        $address = new Address();
        $address->setCountryCode('US');
        $address->setAddressLine1('foo   street');
        $address->setLocality('bar  ');
        $address->setAdministrativeArea('  CA');
        $address->setPostalCode('  12345  ');

        $addressService = new AddressService($this->options);
        $this->assertSame(
            [
                'foo street',
                'bar CA 12345',
                'UNITED STATES',
            ],
            $addressService->formatAddress($address)
        );
    }

    /**
     * @covers ::formatAddress
     */
    public function testFormatAddressDoesNotAddCountryOnUnknwonCountryCode()
    {
        $address = new Address();
        $address->setCountryCode('ZZ');
        $address->setAddressLine1('foo street');
        $address->setLocality('bar');

        $addressService = new AddressService($this->options);
        $this->assertSame(
            [
                'foo street',
                'bar',
            ],
            $addressService->formatAddress($address)
        );
    }

    /**
     * @covers ::formatAddress
     */
    public function testFormatAddressDoesNotAddCountryIfRequested()
    {
        $address = new Address();
        $address->setCountryCode('US');
        $address->setAddressLine1('foo street');
        $address->setLocality('bar');
        $address->setAdministrativeArea('CA');
        $address->setPostalCode('12345');

        $addressService = new AddressService($this->options);
        $this->assertSame(
            [
                'foo street',
                'bar CA 12345'
            ],
            $addressService->formatAddress($address, false)
        );
    }

    /**
     * @covers ::formatAddress
     */
    public function testFormatAddressThrowsExceptionOnInvalidFormat()
    {
        $this->setExpectedException(
            'RuntimeException',
            'Unrecognized character "]" in format pattern "%]"'
        );

        $address = new Address();
        $address->setCountryCode('FR');

        $addressService = new AddressService($this->options);
        $addressService->formatAddress($address);
    }

    /**
     * @covers ::getFieldsForCountry
     */
    public function testGetFieldsForCountryReturnsSpecificFieldsOnKnownCountryCode()
    {
        $addressService = new AddressService($this->options);

        $this->assertSame(
            [
                'recipient'          => false,
                'organization'       => false,
                'addressLine1'       => true,
                'addressLine2'       => false,
                'locality'           => true,
                'administrativeArea' => true,
                'postalCode'         => true,
            ],
            $addressService->getFieldsForCountry('US')
        );
    }

    /**
     * @covers ::getFieldsForCountry
     */
    public function testGetFieldsForCountryReturnsGenericFieldsOnUnknownCountryCode()
    {
        $addressService = new AddressService($this->options);
        $genericFields  = [
            'recipient'    => false,
            'organization' => false,
            'addressLine1' => true,
            'addressLine2' => false,
            'locality'     => true,
        ];

        $this->assertSame($genericFields, $addressService->getFieldsForCountry('FOO'));
        $this->assertSame($genericFields, $addressService->getFieldsForCountry('UK'));
        $this->assertSame($genericFields, $addressService->getFieldsForCountry('DE'));
    }

    /**
     * @covers ::getFieldsForCountry
     */
    public function testGetFieldsForCountryUsesFieldCache()
    {
        $addressService   = new AddressService($this->options);
        $reflectedService = new ReflectionClass($addressService);
        $reflectedCache   = $reflectedService->getProperty('fieldCache');
        $reflectedCache->setAccessible(true);

        $this->assertSame([], $reflectedCache->getValue($addressService));
        $this->assertSame(
            $addressService->getFieldsForCountry('US'),
            $reflectedCache->getValue($addressService)['US']
        );

        $reflectedCache->setValue($addressService, ['US' => ['foo']]);
        $this->assertSame(
            ['foo'],
            $addressService->getFieldsForCountry('US')
        );
    }

    /**
     * @covers ::getCountryCodes
     */
    public function testGetCountryCodesOnlyAccessesFilesystemOnce()
    {
        $addressService = new AddressService($this->options);

        $this->assertSame(['US', 'UK', 'DE', 'FR'], $addressService->getCountryCodes());
        $this->root->removeChild($this->root->url() . '/country-codes.php');
        $this->assertSame(['US', 'UK', 'DE', 'FR'], $addressService->getCountryCodes());
    }
}
