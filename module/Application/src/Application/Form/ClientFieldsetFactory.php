<?php
namespace Application\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClientFieldsetFactory implements FactoryInterface
{
    /**
     * @return ClientFieldset
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        return new ClientFieldset(
            $formElementManager->getServiceLocator()->get('HydratorManager')->get('Application\Hydrator\ClientHydrator')
        );
    }
}
