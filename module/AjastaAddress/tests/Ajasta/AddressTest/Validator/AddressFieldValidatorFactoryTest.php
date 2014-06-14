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
     * @var ServiceManager
     */
    protected $serviceLocator;

    public function setUp()
    {
        $addressService = $this
            ->getMockBuilder('Ajasta\Address\Service\AddressService')
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceLocator = new ServiceManager();
        $this->serviceLocator->setService(
            'Ajasta\Address\Service\AddressService',
            $addressService
        );
    }

    /**
     * @covers ::createService
     */
    public function testFactoryRetrievesServiceLocatorFromPluginManager()
    {
        $pluginManager = $this->getMock('Zend\ServiceManager\AbstractPluginManager');
        $pluginManager
            ->expects($this->once())
            ->method('getServiceLocator')
            ->will($this->returnValue($this->serviceLocator));

        $factory = new AddressFieldValidatorFactory();
        $factory->setCreationOptions(['field' => 'foo']);
        $factory->createService($pluginManager);
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
