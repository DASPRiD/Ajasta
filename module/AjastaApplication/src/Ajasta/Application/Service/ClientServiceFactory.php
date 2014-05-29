<?php
namespace Ajasta\Application\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClientServiceFactory implements FactoryInterface
{
    /**
     * @return ClientService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        return new ClientService(
            $objectManager,
            $objectManager->getRepository('Ajasta\Application\Entity\Client')
        );
    }
}
