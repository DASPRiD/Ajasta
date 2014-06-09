<?php
namespace Ajasta\Invoice;

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

        if (!isset($config['ajasta']['invoice'])) {
            return new Options();
        }

        return new Options($config['ajasta']['invoice']);
    }
}
