<?php
namespace Ajasta\Client\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProjectControllerFactory implements FactoryInterface
{
    /**
     * @return ProjectController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();

        return new ProjectController(
            $serviceLocator->get('Ajasta\Client\Service\ClientService'),
            $serviceLocator->get('Ajasta\Client\Service\ProjectService'),
            $serviceLocator->get('FormElementManager')->get('Ajasta\Client\Form\ProjectForm')
        );
    }
}
