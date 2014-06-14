<?php
namespace Ajasta\Address\View\Helper;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressFormatFactory implements FactoryInterface
{
    /**
     * @return AddressFormat
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        return new AddressFormat(
            $serviceLocator->get('Ajasta\Address\Service\AddressService')
        );
    }
}
