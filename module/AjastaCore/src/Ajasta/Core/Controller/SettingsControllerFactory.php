<?php
namespace Ajasta\Core\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SettingsControllerFactory implements FactoryInterface
{
    /**
     * @return SettingsController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();

        return new SettingsController(
            $serviceLocator->get('Ajasta\Core\Service\SettingsService'),
            $serviceLocator->get('FormElementManager')->get('Ajasta\Core\Form\SettingsForm')
        );
    }
}
