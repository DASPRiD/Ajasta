<?php
namespace Ajasta\Application\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClientControllerFactory implements FactoryInterface
{
    /**
     * @return ClientController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();

        return new ClientController(
            $serviceLocator->get('Ajasta\Application\Service\ClientService'),
            $serviceLocator->get('FormElementManager')->get('Ajasta\Application\Form\ClientForm')
        );
    }
}