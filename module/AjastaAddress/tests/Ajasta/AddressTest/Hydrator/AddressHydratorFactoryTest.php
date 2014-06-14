<?php
namespace Ajasta\AddressTest\Hydrator;

use Ajasta\Address\Hydrator\AddressHydratorFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @coversDefaultClass Ajasta\Address\Hydrator\AddressHydratorFactory
 * @covers ::<!public>
 */
class AddressHydratorFactoryTest extends TestCase
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

        $factory = new AddressHydratorFactory();
        $factory->createService($pluginManager);
    }

    /**
     * @covers ::createService
     */
    public function testFactoryReturnsAddressHydrator()
    {
        $factory = new AddressHydratorFactory();

        $this->assertInstanceOf(
            'Ajasta\Address\Hydrator\AddressHydrator',
            $factory->createService($this->serviceLocator)
        );
    }
}
