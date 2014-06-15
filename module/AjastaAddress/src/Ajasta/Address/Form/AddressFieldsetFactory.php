<?php
namespace Ajasta\Address\Form;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressFieldsetFactory implements FactoryInterface
{
    /**
     * @return AddressFieldset
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator  = FactoryUtils::resolveServiceLocator($serviceLocator);
        $hydratorManager = $serviceLocator->get('HydratorManager');

        return new AddressFieldset(
            $hydratorManager->get('Ajasta\Address\Hydrator\AddressHydrator')
        );
    }
}
