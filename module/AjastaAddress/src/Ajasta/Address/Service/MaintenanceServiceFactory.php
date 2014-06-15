<?php
namespace Ajasta\Address\Service;

use Ajasta\Address\Options;
use Zend\Http\Client as HttpClient;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MaintenanceServiceFactory implements FactoryInterface
{
    /**
     * @return MaintenanceService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options Options */
        $options = $serviceLocator->get('Ajasta\Address\Options');
        /* @var $httpClient HttpClient */
        $httpClient = $serviceLocator->get('Ajasta\Core\Http\Client');

        return new MaintenanceService($options, $httpClient);
    }
}
