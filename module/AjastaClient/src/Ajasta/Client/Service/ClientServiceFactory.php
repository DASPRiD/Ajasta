<?php
namespace Ajasta\Client\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClientServiceFactory implements FactoryInterface
{
    /**
     * @return ClientService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ClientService(
            $serviceLocator->get('doctrine.entitymanager.orm_default')
        );
    }
}
