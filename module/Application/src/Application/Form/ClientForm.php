<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ClientForm extends Form
{
    public function __construct()
    {
        parent::__construct();
    }

    public function init()
    {
        parent::init();

        $this->setAttribute('method', 'post');
        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setInputFilter(new InputFilter());

        $this->add([
            'type' => 'Application\Form\ClientFieldset',
            'options' => [
                'use_as_base_fieldset' => true,
            ],
        ]);

        $this->add([
            'type' => 'button',
            'name' => 'submit',
            'options' => [
                'label' => 'Submit',
                'column-size' => 'sm-12 form-action',
            ],
            'attributes' => [
                'type' => 'submit',
                'class' => 'btn-primary'
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'fullName' => [
                'name' => 'fullName',
                'required' => true,
            ],
            'addressLine1' => [
                'name' => 'fullName',
                'required' => true,
            ],
            'city' => [
                'name' => 'city',
                'required' => true,
            ],
            'country' => [
                'name' => 'country',
                'required' => true,
            ],
        ];
    }
}
