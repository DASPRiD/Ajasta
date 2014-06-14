<?php
namespace Ajasta\AddressTest\View\Helper;

use Ajasta\Address\View\Helper\AddressFormatFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @coversDefaultClass Ajasta\Address\View\Helper\AddressFormatFactory
 * @covers ::<!public>
 */
class AddressFormatFactoryTest extends TestCase
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

        $factory = new AddressFormatFactory();
        $factory->createService($pluginManager);
    }

    /**
     * @covers ::createService
     */
    public function testFactoryReturnsAddressFormat()
    {
        $factory = new AddressFormatFactory();

        $this->assertInstanceOf(
            'Ajasta\Address\View\Helper\AddressFormat',
            $factory->createService($this->serviceLocator)
        );
    }
}
