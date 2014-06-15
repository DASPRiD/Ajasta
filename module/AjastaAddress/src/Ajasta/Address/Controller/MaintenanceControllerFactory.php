<?php
namespace Ajasta\Address\Controller;

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

        return new MaintenanceController(
            $serviceLocator->get('Ajasta\Address\Service\MaintenanceService')
        );
    }
}
