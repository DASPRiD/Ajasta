<?php
namespace Ajasta\AddressTest\Form\Element;

use Ajasta\Address\Form\Element\CountrySelect;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @coversDefaultClass Ajasta\Address\Form\Element\CountrySelect
 * @covers ::<!public>
 */
class CountrySelectTest extends TestCase
{
    /**
     * @var \Ajasta\Address\Service\AddressService|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressService;

    /**
     * @var \Ajasta\I18n\Cldr\Manager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $cldrManager;

    public function setUp()
    {
        $this->addressService = $this
            ->getMockBuilder('Ajasta\Address\Service\AddressService')
            ->disableOriginalConstructor()
            ->getMock();

        $this->cldrManager = $this
            ->getMockBuilder('Ajasta\I18n\Cldr\Manager')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @covers ::__construct
     */
    public function testAddressServiceIsNotTriggeredOnConstruction()
    {
        $this
            ->addressService
            ->expects($this->never())
            ->method('getCountryCodes');

        new CountrySelect($this->addressService, $this->cldrManager);
    }

    /**
     * @covers ::getValueOptions
     */
    public function testGetValueOptionsFormatsValues()
    {
        $this
            ->addressService
            ->expects($this->once())
            ->method('getCountryCodes')
            ->will($this->returnValue([
                'US',
                'DE',
            ]));

        $this
            ->cldrManager
            ->expects($this->any())
            ->method('lookupCountryName')
            ->will($this->returnCallback(function ($countryCode) {
                if ($countryCode === 'US') {
                    return 'United States';
                }

                return 'Germany';
            }));

        $countrySelect = new CountrySelect($this->addressService, $this->cldrManager);

        $this->assertSame(
            [
                'US' => 'United States',
                'DE' => 'Germany',
            ],
            $countrySelect->getValueOptions()
        );
    }

    /**
     * @covers ::getValueOptions
     */
    public function testAddressServiceIsOnlyAskedOnce()
    {
        $this
            ->addressService
            ->expects($this->once())
            ->method('getCountryCodes')
            ->will($this->returnValue([]));

        $countrySelect = new CountrySelect($this->addressService, $this->cldrManager);
        $countrySelect->getValueOptions();
        $countrySelect->getValueOptions();
    }
}
