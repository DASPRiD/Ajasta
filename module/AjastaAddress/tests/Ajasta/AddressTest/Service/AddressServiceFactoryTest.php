<?php
namespace Ajasta\AddressTest\Service;

use Ajasta\Address\Options;
use Ajasta\Address\Service\AddressServiceFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @coversDefaultClass Ajasta\Address\Service\AddressServiceFactory
 * @covers ::<!public>
 */
class AddressServiceFactoryTest extends TestCase
{
    /**
     * @covers ::createService
     */
    public function testFactoryReturnsAddressService()
    {
        $factory = new AddressServiceFactory();

        $serviceLocator = new ServiceManager();
        $serviceLocator->setService(
            'Ajasta\Address\Options',
            new Options()
        );

        $this->assertInstanceOf(
            'Ajasta\Address\Service\AddressService',
            $factory->createService($serviceLocator)
        );
    }
}
