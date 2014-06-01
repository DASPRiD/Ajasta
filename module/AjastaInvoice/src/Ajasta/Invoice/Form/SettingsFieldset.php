<?php
namespace Ajasta\Invoice\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class SettingsFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('invoice');
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'default_vat',
            'type' => 'number',
            'options' => [
                'label' => 'Default VAT',
                'column-size' => 'sm-2',
            ],
            'attributes' => [
                'min' => '0',
                'max' => '100',
                'step' => '0.01',
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'default_unit',
            'type' => 'Ajasta\Core\Form\Element\UnitSelect',
            'options' => [
                'label' => 'Default unit',
                'column-size' => 'sm-2',
            ],
            'attributes' => [
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'default_unit_price',
            'type' => 'number',
            'options' => [
                'label' => 'Default unit price',
                'column-size' => 'sm-2',
            ],
            'attributes' => [
                'min' => '0',
                'step' => '0.01',
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'invoice_incrementer',
            'type' => 'number',
            'options' => [
                'label' => 'Invoice incrementer',
                'column-size' => 'sm-2',
            ],
            'attributes' => [
                'min' => '1',
                'step' => '1',
                'required' => true,
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'default_vat' => [
                'required' => true,
            ],
            'default_unit' => [
                'required' => true,
            ],
            'default_unit_price' => [
                'required' => true,
            ],
            'invoice_incrementer' => [
                'allow_empty' => true,
            ],
        ];
    }
}
