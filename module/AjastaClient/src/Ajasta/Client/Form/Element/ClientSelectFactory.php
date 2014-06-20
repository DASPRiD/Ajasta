<?php
namespace Ajasta\Client\Form\Element;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClientSelectFactory implements FactoryInterface
{
    /**
     * @return ClientSelect
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        return new ClientSelect(
            $serviceLocator->get('Ajasta\Client\Repository\ClientRepository')
        );
    }
}
