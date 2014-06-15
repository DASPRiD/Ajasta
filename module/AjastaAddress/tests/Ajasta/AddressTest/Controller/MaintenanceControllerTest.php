<?php
namespace Ajasta\AddressTest\Controller;

use Ajasta\Address\Controller\MaintenanceController;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @coversDefaultClass Ajasta\Address\Controller\MaintenanceController
 * @covers ::<!public>
 */
class MaintenanceControllerTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::updateAddressFormatsAction
     */
    public function testUpdateAddressFormatsAction()
    {
        $maintenanceService = $this
            ->getMockBuilder('Ajasta\Address\Service\MaintenanceService')
            ->disableOriginalConstructor()
            ->getMock();

        $maintenanceService
            ->expects($this->once())
            ->method('updateAddressFormats')
            ->with($this->isInstanceOf('Zend\ProgressBar\Adapter\Console'));

        $maintenanceController = new MaintenanceController($maintenanceService);
        $maintenanceController->setConsole($this->getMock('Zend\Console\Adapter\AdapterInterface'));
        $maintenanceController->updateAddressFormatsAction();
    }
}
