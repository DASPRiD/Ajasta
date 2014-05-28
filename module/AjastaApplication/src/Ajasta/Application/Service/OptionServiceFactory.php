<?php
namespace Ajasta\Application\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OptionServiceFactory implements FactoryInterface
{
    /**
     * @return OptionService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        return new OptionService(
            $serviceLocator->get('Config')['dynamic_option_defaults'],
            $objectManager,
            $objectManager->getRepository('Ajasta\Application\Entity\Option')
        );
    }
}