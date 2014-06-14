<?php
namespace Ajasta\Address;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OptionsFactory implements FactoryInterface
{
    /**
     * @return Options
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        if (!isset($config['ajasta']['address'])) {
            return new Options();
        }

        return new Options($config['ajasta']['address']);
    }
}
