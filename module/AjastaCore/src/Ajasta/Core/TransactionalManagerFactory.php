<?php
namespace Ajasta\Core;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TransactionalManagerFactory implements FactoryInterface
{
    /**
     * @return callable
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return [
            $serviceLocator->get('doctrine.entitymanager.orm_default'),
            'transactional'
        ];
    }
}
