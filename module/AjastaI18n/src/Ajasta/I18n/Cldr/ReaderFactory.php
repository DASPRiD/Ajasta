<?php
namespace Ajasta\I18n\Cldr;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReaderFactory implements FactoryInterface
{
    /**
     * @return Reader
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Reader(
            $serviceLocator->get('Config')['cldr']['data_path']
        );
    }
}
