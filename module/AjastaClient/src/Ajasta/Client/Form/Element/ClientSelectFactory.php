<?php
namespace Ajasta\Client\Form\Element;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClientSelectFactory implements FactoryInterface
{
    /**
     * @return ClientSelect
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);
        $objectManager  = $serviceLocator->get('doctrine.entitymanager.orm_default');

        return new ClientSelect(
            $objectManager->getRepository('Ajasta\Client\Entity\Client')
        );
    }
}
