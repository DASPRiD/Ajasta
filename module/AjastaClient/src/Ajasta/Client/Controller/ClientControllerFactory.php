<?php
namespace Ajasta\Client\Controller;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClientControllerFactory implements FactoryInterface
{
    /**
     * @return ClientController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator     = FactoryUtils::resolveServiceLocator($serviceLocator);
        $formElementManager = $serviceLocator->get('FormElementManager');

        return new ClientController(
            $serviceLocator->get('Ajasta\Client\Repository\ClientRepository'),
            $serviceLocator->get('Ajasta\Client\Service\ClientService'),
            $formElementManager->get('Ajasta\Client\Form\ClientForm')
        );
    }
}
