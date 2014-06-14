<?php
namespace Ajasta\Client\Controller;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClientControllerFactory implements FactoryInterface
{
    /**
     * @return ClientController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        return new ClientController(
            $serviceLocator->get('Ajasta\Client\Repository\ClientRepository'),
            $serviceLocator->get('Ajasta\Client\Service\ClientService'),
            $serviceLocator->get('FormElementManager')->get('Ajasta\Client\Form\ClientForm')
        );
    }
}
