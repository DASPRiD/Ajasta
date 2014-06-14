<?php
namespace Ajasta\Address\Controller;

use Ajasta\Address\Service\MaintenanceService;
use Zend\Mvc\Controller\AbstractConsoleController;

class MaintenanceController extends AbstractConsoleController
{
    /**
     * @var MaintenanceService
     */
    protected $maintenanceService;

    /**
     * @param MaintenanceService $maintenanceService
     */
    public function __construct(MaintenanceService $maintenanceService)
    {
        $this->maintenanceService = $maintenanceService;
    }

    public function updateAddressFormatsAction()
    {
        $this->getConsole()->writeLine('Updating address formats, this may take a while.');
        $this->maintenanceService->updateAddressFormats();
        $this->getConsole()->writeLine('Address formats have been updated.');
    }
}
