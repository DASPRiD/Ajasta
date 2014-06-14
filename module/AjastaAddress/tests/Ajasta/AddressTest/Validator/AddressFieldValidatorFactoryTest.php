<?php
namespace Ajasta\AddressTest\Validator;

use Ajasta\Address\Validator\AddressFieldValidatorFactory;
use PHPUnit_Framework_TestCase as TestCase;
use ReflectionClass;
use Zend\ServiceManager\ServiceManager;
use Zend\Validator\ValidatorPluginManager;

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
     * @var ValidatorPluginManager
     */
    protected $validatorManager;

    public function setUp()
    {
        $this->addressService = $this
            ->getMockBuilder('Ajasta\Address\Service\AddressService')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceLocator = new ServiceManager();
        $serviceLocator->setService(
            'Ajasta\Address\Service\AddressService',
            $this->addressService
        );

        $this->validatorManager = new ValidatorPluginManager();
        $this->validatorManager->setServiceLocator($serviceLocator);
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
        $factory->createService($this->validatorManager);
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
            $factory->createService($this->validatorManager)
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

        $addressFieldValidator = $factory->createService($this->validatorManager);

        $reflectedValidator = new ReflectionClass($addressFieldValidator);
        $reflectedProperty  = $reflectedValidator->getProperty('fieldName');
        $reflectedProperty->setAccessible(true);

        $this->assertSame('foo', $reflectedProperty->getValue($addressFieldValidator));
    }
}
