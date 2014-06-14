<?php
namespace Ajasta\AddressTest\Validator;

use Ajasta\Address\Validator\AddressFieldValidator;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @coversDefaultClass Ajasta\Address\Validator\AddressFieldValidator
 * @covers ::<!public>
 */
class AddressFieldValidatorTest extends TestCase
{
    /**
     * @var \Ajasta\Address\Service\AddressService|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressService;

    /**
     * @var AddressFieldValidator
     */
    protected $addressFieldValidator;

    public function setUp()
    {
        $this->addressService = $this
            ->getMockBuilder('Ajasta\Address\Service\AddressService')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testFailureOnMissingCountryCode()
    {
        $addressFieldValidator = new AddressFieldValidator($this->addressService, 'foo');

        $this->assertFalse($addressFieldValidator->isValid('foo'));
        $this->assertArrayHasKey(
            AddressFieldValidator::MISSING_COUNTRY_CODE,
            $addressFieldValidator->getMessages()
        );

        $this->assertFalse($addressFieldValidator->isValid('foo', []));
        $this->assertArrayHasKey(
            AddressFieldValidator::MISSING_COUNTRY_CODE,
            $addressFieldValidator->getMessages()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testCountryCodeIsTrimmed()
    {
        $this
            ->addressService
            ->expects($this->once())
            ->method('getFieldsForCountry')
            ->with($this->equalTo('bar'))
            ->will($this->returnValue([]));

        $addressFieldValidator = new AddressFieldValidator($this->addressService, 'foo');
        $addressFieldValidator->isValid('', ['countryCode' => ' bar ']);
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testSuccessOnNonExistentEmptyField()
    {
        $this
            ->addressService
            ->expects($this->once())
            ->method('getFieldsForCountry')
            ->with($this->equalTo('bar'))
            ->will($this->returnValue([]));

        $addressFieldValidator = new AddressFieldValidator($this->addressService, 'foo');
        $this->assertTrue($addressFieldValidator->isValid('', ['countryCode' => 'bar']));
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testSuccessOnNonRequiredEmptyField()
    {
        $this
            ->addressService
            ->expects($this->once())
            ->method('getFieldsForCountry')
            ->with($this->equalTo('bar'))
            ->will($this->returnValue(['foo' => false]));

        $addressFieldValidator = new AddressFieldValidator($this->addressService, 'foo');
        $this->assertTrue($addressFieldValidator->isValid('', ['countryCode' => 'bar']));
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testSuccessOnRequiredNonEmptyField()
    {
        $this
            ->addressService
            ->expects($this->once())
            ->method('getFieldsForCountry')
            ->with($this->equalTo('bar'))
            ->will($this->returnValue(['foo' => true]));

        $addressFieldValidator = new AddressFieldValidator($this->addressService, 'foo');
        $this->assertTrue($addressFieldValidator->isValid('foo', ['countryCode' => 'bar']));
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testFailureOnRequiredEmptyField()
    {
        $this
            ->addressService
            ->expects($this->once())
            ->method('getFieldsForCountry')
            ->with($this->equalTo('bar'))
            ->will($this->returnValue(['foo' => true]));

        $addressFieldValidator = new AddressFieldValidator($this->addressService, 'foo');
        $this->assertFalse($addressFieldValidator->isValid('', ['countryCode' => 'bar']));
        $this->assertArrayHasKey(
            AddressFieldValidator::IS_EMPTY,
            $addressFieldValidator->getMessages()
        );
    }
}
