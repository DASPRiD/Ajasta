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
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        /* @var $formElementManager \Zend\Form\FormElementManager */
        $formElementManager = $serviceLocator->get('FormElementManager');
        /* @var $clientRepository \Ajasta\Client\Repository\ClientRepository */
        $clientRepository = $serviceLocator->get('Ajasta\Client\Repository\ClientRepository');
        /* @var $clientService \Ajasta\Client\Service\ClientService */
        $clientService = $serviceLocator->get('Ajasta\Client\Service\ClientService');
        /* @var $clientForm \Ajasta\Client\Form\ClientForm */
        $clientForm = $formElementManager->get('Ajasta\Client\Form\ClientForm');

        return new ClientController($clientRepository, $clientService, $clientForm);
    }
}
