<?php
namespace Ajasta\AddressTest\Form;

use Ajasta\Address\Form\AddressFieldsetFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @coversDefaultClass Ajasta\Address\Form\AddressFieldsetFactory
 * @covers ::<!public>
 */
class AddressFieldsetFactoryTest extends TestCase
{
    /**
     * @var ServiceManager
     */
    protected $serviceLocator;

    public function setUp()
    {
        $addressHydrator = $this
            ->getMockBuilder('Ajasta\Address\Hydrator\AddressHydrator')
            ->disableOriginalConstructor()
            ->getMock();

        $hydratorManager = new ServiceManager();
        $hydratorManager->setService(
            'Ajasta\Address\Hydrator\AddressHydrator',
            $addressHydrator
        );

        $this->serviceLocator = new ServiceManager();
        $this->serviceLocator->setService(
            'HydratorManager',
            $hydratorManager
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

        $factory = new AddressFieldsetFactory();
        $factory->createService($pluginManager);
    }

    /**
     * @covers ::createService
     */
    public function testFactoryReturnsAddressFieldset()
    {
        $factory = new AddressFieldsetFactory();

        $this->assertInstanceOf(
            'Ajasta\Address\Form\AddressFieldset',
            $factory->createService($this->serviceLocator)
        );
    }
}
