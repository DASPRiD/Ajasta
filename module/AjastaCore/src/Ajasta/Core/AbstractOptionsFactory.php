<?php
namespace Ajasta\Core;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\AbstractOptions;

abstract class AbstractOptionsFactory implements FactoryInterface
{
    const CONFIG_KEY    = 'undefined';
    const OPTIONS_CLASS = 'undefined';

    /**
     * @return AbstractOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $optionsClass = static::OPTIONS_CLASS;
        $config       = $serviceLocator->get('Config');

        if (!isset($config['ajasta'][static::CONFIG_KEY])) {
            return new $optionsClass();
        }

        return new $optionsClass($config['ajasta'][static::CONFIG_KEY]);
    }
}
