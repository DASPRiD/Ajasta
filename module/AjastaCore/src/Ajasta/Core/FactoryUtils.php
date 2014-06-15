<?php
namespace Ajasta\Core;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class FactoryUtils
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ServiceLocatorInterface
     */
    public static function resolveServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            return $serviceLocator->getServiceLocator();
        }

        return $serviceLocator;
    }
}