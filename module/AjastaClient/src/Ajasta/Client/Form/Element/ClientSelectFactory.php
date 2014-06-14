<?php
namespace Ajasta\Client\Form\Element;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClientSelectFactory implements FactoryInterface
{
    /**
     * @return ClientSelect
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        return new ClientSelect(
            $objectManager->getRepository('Ajasta\Client\Entity\Client')
        );
    }
}
