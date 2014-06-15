<?php
namespace Ajasta\AddressTest\Controller;

use Ajasta\Address\Controller\MaintenanceControllerFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @coversDefaultClass Ajasta\Address\Controller\MaintenanceControllerFactory
 * @covers ::<!public>
 */
class MaintenanceControllerFactoryTest extends TestCase
{
    /**
     * @var ServiceManager
     */
    protected $serviceLocator;

    public function setUp()
    {
        $addressService = $this
            ->getMockBuilder('Ajasta\Address\Service\MaintenanceService')
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceLocator = new ServiceManager();
        $this->serviceLocator->setService(
            'Ajasta\Address\Service\MaintenanceService',
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

        $factory = new MaintenanceControllerFactory();
        $factory->createService($pluginManager);
    }

    /**
     * @covers ::createService
     */
    public function testFactoryReturnsIndexController()
    {
        $factory = new MaintenanceControllerFactory();

        $this->assertInstanceOf(
            'Ajasta\Address\Controller\MaintenanceController',
            $factory->createService($this->serviceLocator)
        );
    }
}
