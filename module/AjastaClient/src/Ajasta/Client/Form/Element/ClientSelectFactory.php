<?php
namespace Ajasta\Client\Form\Element;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClientSelectFactory implements FactoryInterface
{
    /**
     * @return ClientSelect
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $objectManager = $formElementManager->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        return new ClientSelect(
            $objectManager->getRepository('Ajasta\Client\Entity\Client')
        );
    }
}
