<?php
namespace Ajasta\Address\Form;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressFieldsetFactory implements FactoryInterface
{
    /**
     * @return AddressFieldset
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        return new AddressFieldset(
            $serviceLocator->get('HydratorManager')->get('Ajasta\Address\Hydrator\AddressHydrator')
        );
    }
}
