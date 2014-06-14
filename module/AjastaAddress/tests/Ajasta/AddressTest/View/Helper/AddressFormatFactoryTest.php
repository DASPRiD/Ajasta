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
     * @covers ::createService
     */
    public function testFactoryReturnsAddressFormat()
    {
        $addressService = $this
            ->getMockBuilder('Ajasta\Address\Service\AddressService')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceLocator = new ServiceManager();
        $serviceLocator->setService(
            'Ajasta\Address\Service\AddressService',
            $addressService
        );

        $factory = new AddressFormatFactory();

        $this->assertInstanceOf(
            'Ajasta\Address\View\Helper\AddressFormat',
            $factory->createService($serviceLocator)
        );
    }
}
