<?php
namespace Ajasta\AddressTest\Controller;

use Ajasta\Address\Controller\IndexControllerFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @coversDefaultClass Ajasta\Address\Controller\IndexControllerFactory
 * @covers ::<!public>
 */
class IndexControllerFactoryTest extends TestCase
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

        $factory = new IndexControllerFactory();
        $factory->createService($pluginManager);
    }

    /**
     * @covers ::createService
     */
    public function testFactoryReturnsIndexController()
    {
        $factory = new IndexControllerFactory();

        $this->assertInstanceOf(
            'Ajasta\Address\Controller\IndexController',
            $factory->createService($this->serviceLocator)
        );
    }
}
