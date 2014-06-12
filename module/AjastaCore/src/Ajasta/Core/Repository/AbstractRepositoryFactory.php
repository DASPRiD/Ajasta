<?php
namespace Ajasta\Core\Repository;

use RuntimeException;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractRepositoryFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return (
            preg_match('(^Ajasta\\\\\D\w+\\\\Repository\\\\\D\w+Repository$)', $requestedName)
            && class_exists($requestedName)
        );
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (
            !preg_match(
                '(^Ajasta\\\\(?P<module>\D\w+)\\\\Repository\\\\(?P<entity>\D\w+)Repository$)',
                $requestedName,
                $match
            )
            || !class_exists($requestedName)
        ) {
            throw new RuntimeException(sprintf(
                'This abstract factory cannot create service with name "%s"',
                $requestedName
            ));
        }

        return new $requestedName(
            $serviceLocator->get('doctrine.entitymanager.orm_default')->getRepository(
                'Ajasta\\' . $match['module'] . '\Entity\\' . $match['entity']
            )
        );
    }
}
