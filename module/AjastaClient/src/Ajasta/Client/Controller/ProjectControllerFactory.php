<?php
namespace Ajasta\Client\Controller;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProjectControllerFactory implements FactoryInterface
{
    /**
     * @return ProjectController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        return new ProjectController(
            $serviceLocator->get('Ajasta\Client\Repository\ClientRepository'),
            $serviceLocator->get('Ajasta\Client\Repository\ProjectRepository'),
            $serviceLocator->get('Ajasta\Client\Service\ProjectService'),
            $serviceLocator->get('FormElementManager')->get('Ajasta\Client\Form\ProjectForm')
        );
    }
}
