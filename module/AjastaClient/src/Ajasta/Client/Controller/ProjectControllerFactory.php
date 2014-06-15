<?php
namespace Ajasta\Client\Controller;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProjectControllerFactory implements FactoryInterface
{
    /**
     * @return ProjectController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator     = FactoryUtils::resolveServiceLocator($serviceLocator);
        $formElementManager = $serviceLocator->get('FormElementManager');

        return new ProjectController(
            $serviceLocator->get('Ajasta\Client\Repository\ClientRepository'),
            $serviceLocator->get('Ajasta\Client\Repository\ProjectRepository'),
            $serviceLocator->get('Ajasta\Client\Service\ProjectService'),
            $formElementManager->get('Ajasta\Client\Form\ProjectForm')
        );
    }
}
