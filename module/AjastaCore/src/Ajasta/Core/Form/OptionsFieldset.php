<?php
namespace Ajasta\Core\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class OptionsFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('options');
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'invoice.email.sender-address',
            'type' => 'email',
            'options' => [
                'label' => 'Sender address',
                'column-size' => 'sm-4',
            ],
            'attributes' => [
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'invoice.email.sender-name',
            'type' => 'text',
            'options' => [
                'label' => 'Sender address',
                'column-size' => 'sm-4',
            ],
            'attributes' => [
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'invoice.default.value-added-tax',
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
            'name' => 'invoice.default.unit',
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
            'name' => 'invoice.default.unit-price',
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
            'name' => 'invoice.invoice-incrementer',
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
            'invoice.email.sender-address' => [
                'required' => true,
            ],
            'invoice.email.sender-name' => [
                'required' => true,
            ],
            'invoice.default.value-added-tax' => [
                'required' => true,
            ],
            'invoice.default.unit' => [
                'required' => true,
            ],
            'invoice.default.unit-price' => [
                'required' => true,
            ],
            'invoice.invoice-incrementer' => [
                'allow_empty' => true,
            ],
        ];
    }
}
