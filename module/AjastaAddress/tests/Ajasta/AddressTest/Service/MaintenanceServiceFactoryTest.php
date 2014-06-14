<?php
namespace Ajasta\AddressTest\Service;

use Ajasta\Address\Options;
use Ajasta\Address\Service\MaintenanceServiceFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Http\Client as HttpClient;
use Zend\ServiceManager\ServiceManager;

/**
 * @coversDefaultClass Ajasta\Address\Service\MaintenanceServiceFactory
 * @covers ::<!public>
 */
class MaintenanceServiceFactoryTest extends TestCase
{
    /**
     * @covers ::createService
     */
    public function testFactoryReturnsMaintenanceService()
    {
        $factory = new MaintenanceServiceFactory();

        $serviceLocator = new ServiceManager();
        $serviceLocator->setService(
            'Ajasta\Address\Options',
            new Options()
        );
        $serviceLocator->setService(
            'Ajasta\Core\Http\Client',
            new HttpClient()
        );

        $this->assertInstanceOf(
            'Ajasta\Address\Service\MaintenanceService',
            $factory->createService($serviceLocator)
        );
    }
}
