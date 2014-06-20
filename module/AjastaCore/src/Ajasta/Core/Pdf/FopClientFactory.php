<?php
namespace Ajasta\Core\Pdf;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FopClientFactory implements FactoryInterface
{
    /**
     * @return FopClient
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new FopClient(
            $serviceLocator->get('Ajasta\Core\Options')->getFopPath()
        );
    }
}
