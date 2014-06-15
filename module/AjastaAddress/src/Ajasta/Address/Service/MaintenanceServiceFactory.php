<?php
namespace Ajasta\Address\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MaintenanceServiceFactory implements FactoryInterface
{
    /**
     * @return MaintenanceService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new MaintenanceService(
            $serviceLocator->get('Ajasta\Address\Options'),
            $serviceLocator->get('Ajasta\Core\Http\Client')
        );
    }
}
