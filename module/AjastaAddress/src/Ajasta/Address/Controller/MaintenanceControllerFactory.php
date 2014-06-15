<?php
namespace Ajasta\Address\Controller;

use Ajasta\Address\Service\MaintenanceService;
use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MaintenanceControllerFactory implements FactoryInterface
{
    /**
     * @return MaintenanceController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        /* @var $addressService MaintenanceService */
        $maintenanceService = $serviceLocator->get('Ajasta\Address\Service\MaintenanceService');

        return new MaintenanceController($maintenanceService);
    }
}
