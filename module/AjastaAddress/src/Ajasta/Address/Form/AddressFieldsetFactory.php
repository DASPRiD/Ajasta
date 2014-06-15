<?php
namespace Ajasta\Address\Form;

use Ajasta\Address\Hydrator\AddressHydrator;
use Ajasta\Core\FactoryUtils;
use Zend\Stdlib\Hydrator\HydratorPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressFieldsetFactory implements FactoryInterface
{
    /**
     * @return AddressFieldset
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        /* @var $hydratorManager HydratorPluginManager */
        $hydratorManager = $serviceLocator->get('HydratorManager');
        /* @var $addressHydrator AddressHydrator */
        $addressHydrator = $hydratorManager->get('Ajasta\Address\Hydrator\AddressHydrator');

        return new AddressFieldset($addressHydrator);
    }
}
