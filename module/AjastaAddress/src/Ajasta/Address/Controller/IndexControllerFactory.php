<?php
namespace Ajasta\Address\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();

        return new IndexController(
            $serviceLocator->get('Ajasta\Address\Service\AddressService')
        );
    }
}