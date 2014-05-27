<?php
namespace Application\Hydrator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressHydratorFactory implements FactoryInterface
{
    /**
     * @return AddressHydrator
     */
    public function createService(ServiceLocatorInterface $validatorManager)
    {
        return new AddressHydrator(
            $validatorManager->getServiceLocator()->get('Application\Service\AddressService')
        );
    }
}
