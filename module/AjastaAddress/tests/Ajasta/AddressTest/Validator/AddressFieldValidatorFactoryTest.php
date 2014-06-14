<?php
namespace Ajasta\AddressTest\Validator;

use Ajasta\Address\Validator\AddressFieldValidatorFactory;
use PHPUnit_Framework_TestCase as TestCase;
use ReflectionClass;
use Zend\ServiceManager\ServiceManager;

/**
 * @coversDefaultClass Ajasta\Address\Validator\AddressFieldValidatorFactory
 * @covers ::<!public>
 */
class AddressFieldValidatorFactoryTest extends TestCase
{
    /**
     * @var \Ajasta\Address\Service\AddressService|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressService;

    /**
     * @var ServiceManager
     */
    protected $serviceLocator;

    public function setUp()
    {
        $this->addressService = $this
            ->getMockBuilder('Ajasta\Address\Service\AddressService')
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceLocator = new ServiceManager();
        $this->serviceLocator->setService(
            'Ajasta\Address\Service\AddressService',
            $this->addressService
        );
    }

    /**
     * @covers ::createService
     */
    public function testFactoryFailsWithoutFieldOption()
    {
        $this->setExpectedException(
            'RuntimeException',
            'Missing option "field"'
        );

        $factory = new AddressFieldValidatorFactory();
        $factory->createService($this->serviceLocator);
    }

    /**
     * @covers ::setCreationOptions
     * @covers ::createService
     */
    public function testFactoryReturnsAddressFieldValidator()
    {
        $factory = new AddressFieldValidatorFactory();
        $factory->setCreationOptions(['field' => 'foo']);

        $this->assertInstanceOf(
            'Ajasta\Address\Validator\AddressFieldValidator',
            $factory->createService($this->serviceLocator)
        );
    }

    /**
     * @covers ::setCreationOptions
     * @covers ::createService
     */
    public function testFactoryInjectsFieldOption()
    {
        $factory = new AddressFieldValidatorFactory();
        $factory->setCreationOptions(['field' => 'foo']);

        $addressFieldValidator = $factory->createService($this->serviceLocator);

        $reflectedValidator = new ReflectionClass($addressFieldValidator);
        $reflectedProperty  = $reflectedValidator->getProperty('fieldName');
        $reflectedProperty->setAccessible(true);

        $this->assertSame('foo', $reflectedProperty->getValue($addressFieldValidator));
    }
}
