<?php
namespace Ajasta\AddressTest\Hydrator;

use Ajasta\Address\Entity\Address;
use Ajasta\Address\Hydrator\AddressHydrator;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @coversDefaultClass Ajasta\Address\Hydrator\AddressHydrator
 * @covers ::<!public>
 */
class AddressHydratorTest extends TestCase
{
    /**
     * @var \Ajasta\Address\Service\AddressService|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressService;

    public function setUp()
    {
        $this->addressService = $this
            ->getMockBuilder('Ajasta\Address\Service\AddressService')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @covers ::hydrate
     */
    public function testHydrateThrowsExceptionOnMissingCountryCode()
    {
        $this->setExpectedException(
            'RuntimeException',
            'Missing countryCode in data'
        );

        $hydrator = new AddressHydrator($this->addressService);
        $hydrator->hydrate([], new Address());
    }

    /**
     * @covers ::__construct
     * @covers ::hydrate
     */
    public function testHydrateClearsNonRequiredFields()
    {
        $this
            ->addressService
            ->expects($this->once())
            ->method('getFieldsForCountry')
            ->with($this->equalTo('foo'))
            ->will($this->returnValue([
                'addressLine1' => true,
                'addressLine2' => false,
            ]));

        $hydrator = new AddressHydrator($this->addressService);
        $address = $hydrator->hydrate(
            [
                'countryCode'  => 'foo',
                'addressLine1' => 'bar',
                'locality'     => 'baz',
            ],
            new Address()
        );

        $this->assertSame('foo', $address->getCountryCode());
        $this->assertSame('bar', $address->getAddressLine1());
        $this->assertNull($address->getAddressLine2());
        $this->assertNull($address->getLocality());
    }
}
