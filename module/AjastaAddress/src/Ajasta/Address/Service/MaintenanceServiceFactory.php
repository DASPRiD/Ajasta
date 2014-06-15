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
        /* @var $options    Options */
        /* @var $httpClient HttpClient */
        $options    = $serviceLocator->get('Ajasta\Address\Options');
        $httpClient = $serviceLocator->get('Ajasta\Core\Http\Client');

        return new MaintenanceService($options, $httpClient);
    }
}
