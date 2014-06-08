<?php
namespace Ajasta\Invoice\Hydrator;

use Ajasta\Core\Hydrator\Strategy\DateStrategy;
use Ajasta\Core\Hydrator\Strategy\EntityStrategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class InvoiceHydratorFactory implements FactoryInterface
{
    /**
     * @return ClassMethodsHydrator
     */
    public function createService(ServiceLocatorInterface $hydratorManager)
    {
        $objectManager = $hydratorManager->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $hydrator      = new ClassMethodsHydrator(false);

        $hydrator->addStrategy(
            'client',
            new EntityStrategy($objectManager->getRepository('Ajasta\Client\Entity\Client'))
        );
        $hydrator->addStrategy(
            'project',
            new EntityStrategy($objectManager->getRepository('Ajasta\Client\Entity\Project'))
        );
        $hydrator->addStrategy('issueDate', new DateStrategy());
        $hydrator->addStrategy('dueDate', new DateStrategy());

        return $hydrator;
    }
}
