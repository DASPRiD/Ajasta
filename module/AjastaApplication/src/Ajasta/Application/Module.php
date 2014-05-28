<?php
namespace Ajasta\Application;

use Locale;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        // Hard-coded until later
        Locale::setDefault('en-US');

        // There's no configuration way to handle this right now…
        $event
            ->getApplication()
            ->getServiceManager()
            ->get('ViewHelperManager')
            ->get('form_element')
            ->addType('toggle', 'Ajasta\Application\Form\View\Helper\FormToggle');
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../../config/module.config.php';
    }
}
