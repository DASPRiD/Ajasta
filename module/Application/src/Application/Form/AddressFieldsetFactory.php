<?php
namespace Application\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressFieldsetFactory implements FactoryInterface
{
    /**
     * @return AddressFieldset
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        return new AddressFieldset(
            $formElementManager->getServiceLocator()->get('HydratorManager')->get('Application\Hydrator\AddressHydrator')
        );
    }
}
