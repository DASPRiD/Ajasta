<?php
namespace Application;

use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        // There's no configuration way to handle this right now…
        $event
            ->getApplication()
            ->getServiceManager()
            ->get('ViewHelperManager')
            ->get('form_element')
            ->addType('toggle', 'Application\Form\View\Helper\FormToggle');
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}
