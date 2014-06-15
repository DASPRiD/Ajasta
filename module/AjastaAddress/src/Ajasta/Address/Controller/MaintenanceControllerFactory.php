<?php
namespace Ajasta\Address\Controller;

use Ajasta\Address\Service\MaintenanceService;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MaintenanceControllerFactory implements FactoryInterface
{
    /**
     * @return MaintenanceController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        /* @var $addressService MaintenanceService */
        $maintenanceService = $serviceLocator->get('Ajasta\Address\Service\MaintenanceService');

        return new MaintenanceController($maintenanceService);
    }
}
