<?php
namespace Ajasta\AddressTest\Entity;

use Ajasta\Address\Entity\Address;
use PHPUnit_Framework_TestCase as TestCase;
use ReflectionClass;

/**
 * @coversDefaultClass Ajasta\Address\Entity\Address
 * @covers ::<!public>
 */
class AddressTest extends TestCase
{
    /**
     * @var Address
     */
    protected $address;

    public function setUp()
    {
        $this->address = new Address();
    }

    /**
     * @covers ::getId
     */
    public function testGetId()
    {
        $this->assertNull($this->address->getId());

        $reflectedAddress = new ReflectionClass($this->address);
        $reflectedId      = $reflectedAddress->getProperty('id');
        $reflectedId->setAccessible(true);
        $reflectedId->setValue($this->address, 1);

        $this->assertSame(1, $this->address->getId());
    }

    /**
     * @covers ::setRecipient
     * @covers ::getRecipient
     */
    public function testSetGetRecipient()
    {
        $this->address->setRecipient('foo');
        $this->assertSame('foo', $this->address->getRecipient());
    }

    /**
     * @covers ::setOrganization
     * @covers ::getOrganization
     */
    public function testSetGetOrganization()
    {
        $this->address->setOrganization('foo');
        $this->assertSame('foo', $this->address->getOrganization());
    }

    /**
     * @covers ::setAddressLine1
     * @covers ::getAddressLine1
     */
    public function testSetGetAddressLine1()
    {
        $this->address->setAddressLine1('foo');
        $this->assertSame('foo', $this->address->getAddressLine1());
    }

    /**
     * @covers ::setAddressLine2
     * @covers ::getAddressLine2
     */
    public function testSetGetAddressLine2()
    {
        $this->address->setAddressLine2('foo');
        $this->assertSame('foo', $this->address->getAddressLine2());
    }

    /**
     * @covers ::setLocality
     * @covers ::getLocality
     */
    public function testSetGetLocality()
    {
        $this->address->setLocality('foo');
        $this->assertSame('foo', $this->address->getLocality());
    }

    /**
     * @covers ::setDependentLocality
     * @covers ::getDependentLocality
     */
    public function testSetGetDependentLocality()
    {
        $this->address->setDependentLocality('foo');
        $this->assertSame('foo', $this->address->getDependentLocality());
    }

    /**
     * @covers ::setAdministrativeArea
     * @covers ::getAdministrativeArea
     */
    public function testSetGetAdministrativeArea()
    {
        $this->address->setAdministrativeArea('foo');
        $this->assertSame('foo', $this->address->getAdministrativeArea());
    }

    /**
     * @covers ::setPostalCode
     * @covers ::getPostalCode
     */
    public function testSetGetPostalCode()
    {
        $this->address->setPostalCode('foo');
        $this->assertSame('foo', $this->address->getPostalCode());
    }

    /**
     * @covers ::setSortingCode
     * @covers ::getSortingCode
     */
    public function testSetGetSortingCode()
    {
        $this->address->setSortingCode('foo');
        $this->assertSame('foo', $this->address->getSortingCode());
    }

    /**
     * @covers ::setCountryCode
     * @covers ::getCountryCode
     */
    public function testSetGetCountryCode()
    {
        $this->address->setCountryCode('foo');
        $this->assertSame('foo', $this->address->getCountryCode());
    }
}
