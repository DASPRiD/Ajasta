<?php
namespace Ajasta\Invoice\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class InvoiceForm extends Form
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
            'type' => 'Ajasta\Invoice\Form\InvoiceFieldset',
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
}
