<?php
namespace Ajasta\Core\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OptionControllerFactory implements FactoryInterface
{
    /**
     * @return OptionController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();

        return new OptionController(
            $serviceLocator->get('Ajasta\Core\Service\OptionService'),
            $serviceLocator->get('FormElementManager')->get('Ajasta\Core\Form\OptionForm')
        );
    }
}
