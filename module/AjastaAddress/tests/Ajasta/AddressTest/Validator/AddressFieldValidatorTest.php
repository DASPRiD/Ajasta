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

        $this->addressFieldValidator = new AddressFieldValidator(
            $this->addressService,
            'foo'
        );
    }

    /**
     * @covers ::isValid
     */
    public function testFailureOnMissingCountryCode()
    {
        $this->assertFalse($this->addressFieldValidator->isValid('foo'));
        $this->assertArrayHasKey(
            AddressFieldValidator::MISSING_COUNTRY_CODE,
            $this->addressFieldValidator->getMessages()
        );

        $this->assertFalse($this->addressFieldValidator->isValid('foo', []));
        $this->assertArrayHasKey(
            AddressFieldValidator::MISSING_COUNTRY_CODE,
            $this->addressFieldValidator->getMessages()
        );
    }

    /**
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

        $this->addressFieldValidator->isValid('', ['countryCode' => ' bar ']);
    }

    /**
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

        $this->assertTrue($this->addressFieldValidator->isValid('', ['countryCode' => 'bar']));
    }

    /**
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

        $this->assertTrue($this->addressFieldValidator->isValid('', ['countryCode' => 'bar']));
    }

    /**
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

        $this->assertTrue($this->addressFieldValidator->isValid('foo', ['countryCode' => 'bar']));
    }

    /**
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

        $this->assertFalse($this->addressFieldValidator->isValid('', ['countryCode' => 'bar']));
        $this->assertArrayHasKey(
            AddressFieldValidator::IS_EMPTY,
            $this->addressFieldValidator->getMessages()
        );
    }
}
