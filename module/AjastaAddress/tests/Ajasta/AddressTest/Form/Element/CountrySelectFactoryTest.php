<?php
namespace Ajasta\AddressTest\Form\Element;

use Ajasta\Address\Form\Element\CountrySelectFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @coversDefaultClass Ajasta\Address\Form\Element\CountrySelectFactory
 * @covers ::<!public>
 */
class CountrySelectFactoryTest extends TestCase
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

        $cldrManager = $this
            ->getMockBuilder('Ajasta\I18n\Cldr\Manager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceLocator = new ServiceManager();
        $this->serviceLocator->setService(
            'Ajasta\Address\Service\AddressService',
            $addressService
        );
        $this->serviceLocator->setService(
            'Ajasta\I18n\Cldr\Manager',
            $cldrManager
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

        $factory = new CountrySelectFactory();
        $factory->createService($pluginManager);
    }

    /**
     * @covers ::createService
     */
    public function testFactoryReturnsCountrySelect()
    {
        $factory = new CountrySelectFactory();

        $this->assertInstanceOf(
            'Ajasta\Address\Form\Element\CountrySelect',
            $factory->createService($this->serviceLocator)
        );
    }
}
