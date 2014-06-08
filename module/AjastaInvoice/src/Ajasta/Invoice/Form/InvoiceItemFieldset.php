<?php
namespace Ajasta\Invoice\Form;

use Ajasta\Invoice\Entity\InvoiceItem;
use Zend\Filter\Null as NullFilter;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class InvoiceItemFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('invoiceItem');
    }

    public function init()
    {
        parent::init();

        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setObject(new InvoiceItem());

        $this->add([
            'name' => 'description',
            'type' => 'text',
            'options' => [
                'label' => 'Description',
                'column-size' => 'sm-4',
            ],
            'attributes' => [
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'quantity',
            'type' => 'number',
            'options' => [
                'label' => 'Quantity',
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
            'name' => 'unit',
            'type' => 'Ajasta\Core\Form\Element\UnitSelect',
            'options' => [
                'label' => 'Unit',
                'column-size' => 'sm-2',
            ],
        ]);

        $this->add([
            'name' => 'unitPrice',
            'type' => 'number',
            'options' => [
                'label' => 'Unit price',
                'column-size' => 'sm-2',
            ],
            'attributes' => [
                'min' => '0',
                'step' => '0.01',
                'required' => true,
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'description' => [
                'required' => true,
            ],
            'quantity' => [
                'required' => true,
            ],
            'unit' => [
                'allow_empty' => true,
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => NullFilter::TYPE_STRING]],
                ],
            ],
            'unitPrice' => [
                'required' => true,
            ],
        ];
    }
}
