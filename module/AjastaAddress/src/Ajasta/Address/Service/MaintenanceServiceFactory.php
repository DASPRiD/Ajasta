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
        /* @var $options \Ajasta\Address\Options */
        $options = $serviceLocator->get('Ajasta\Address\Options');
        /* @var $httpClient \Zend\Http\Client */
        $httpClient = $serviceLocator->get('Ajasta\Core\Http\Client');

        return new MaintenanceService($options, $httpClient);
    }
}
