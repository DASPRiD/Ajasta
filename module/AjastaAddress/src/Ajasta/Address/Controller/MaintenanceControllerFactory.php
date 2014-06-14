<?php
namespace Ajasta\Address\Controller;

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

        return new MaintenanceController(
            $serviceLocator->get('Ajasta\Address\Service\MaintenanceService')
        );
    }
}
