<?php
namespace Ajasta\Core\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SettingsServiceFactory implements FactoryInterface
{
    /**
     * @return SettingsService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        return new SettingsService(
            $serviceLocator->get('Config')['setting_defaults'],
            $objectManager,
            $objectManager->getRepository('Ajasta\Core\Entity\Setting')
        );
    }
}
