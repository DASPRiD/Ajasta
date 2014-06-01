<?php
namespace Ajasta\Invoice\Form;

use Ajasta\Core\Form\SettingsFieldset;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SettingsFieldsetDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * @return SettingsFieldset
     */
    public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
    {
        $fieldset = $callback();

        $fieldset->add([
            'type' => 'Ajasta\Invoice\Form\SettingsFieldset',
            'name' => 'invoice',
            'options' => [
                'label' => 'Invoice'
            ],
        ], [
            'priority' => -200,
        ]);

        return $fieldset;
    }
}
