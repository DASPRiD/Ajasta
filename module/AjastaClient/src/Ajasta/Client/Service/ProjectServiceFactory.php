<?php
namespace Ajasta\Client\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProjectServiceFactory implements FactoryInterface
{
    /**
     * @return ProjectService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ProjectService($serviceLocator->get('doctrine.entitymanager.orm_default'));
    }
}
