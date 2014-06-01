<?php
namespace Ajasta\Core\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class SettingsFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('settings');
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'email_sender_address',
            'type' => 'email',
            'options' => [
                'label' => 'Email sender address',
                'column-size' => 'sm-4',
            ],
            'attributes' => [
                'required' => true,
            ],
        ], [
            'priority' => -101,
        ]);

        $this->add([
            'name' => 'email_sender_name',
            'type' => 'text',
            'options' => [
                'label' => 'Email sender name',
                'column-size' => 'sm-4',
            ],
            'attributes' => [
                'required' => true,
            ],
        ], [
            'priority' => -102,
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'email_sender_address' => [
                'required' => true,
            ],
            'email_sender_name' => [
                'required' => true,
            ],
        ];
    }
}
