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
        $objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        return new ProjectService(
            $objectManager,
            $objectManager->getRepository('Ajasta\Client\Entity\Project')
        );
    }
}
