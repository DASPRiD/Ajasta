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
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        /* @var $hydratorManager \Zend\Stdlib\Hydrator\HydratorPluginManager */
        $hydratorManager = $serviceLocator->get('HydratorManager');
        /* @var $addressHydrator \Ajasta\Address\Hydrator\AddressHydrator */
        $addressHydrator = $hydratorManager->get('Ajasta\Address\Hydrator\AddressHydrator');

        return new AddressFieldset($addressHydrator);
    }
}
