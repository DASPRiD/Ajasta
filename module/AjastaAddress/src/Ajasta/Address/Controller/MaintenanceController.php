<?php
namespace Ajasta\Address\Controller;

use Ajasta\Address\Service\MaintenanceService;
use Zend\Mvc\Controller\AbstractConsoleController;
use Zend\ProgressBar\Adapter\Console as ConsoleAdapter;

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
        $this->maintenanceService->updateAddressFormats(new ConsoleAdapter());
        $this->getConsole()->writeLine('Address formats have been updated.');
    }
}
