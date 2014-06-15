<?php
namespace Ajasta\Address\Form;

use Ajasta\Address\Hydrator\AddressHydrator;
use Zend\Stdlib\Hydrator\HydratorPluginManager;
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

        /* @var $hydratorManager HydratorPluginManager */
        /* @var $addressHydrator AddressHydrator */
        $hydratorManager = $serviceLocator->get('HydratorManager');
        $addressHydrator = $hydratorManager->get('Ajasta\Address\Hydrator\AddressHydrator');

        return new AddressFieldset($addressHydrator);
    }
}
