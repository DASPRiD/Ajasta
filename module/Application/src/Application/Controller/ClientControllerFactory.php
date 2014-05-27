<?php
namespace Application\Controller;

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
            $serviceLocator->get('Application\Service\ClientService'),
            $serviceLocator->get('FormElementManager')->get('Application\Form\ClientForm'),
            $serviceLocator->get('Application\Service\AddressService')
        );
    }
}