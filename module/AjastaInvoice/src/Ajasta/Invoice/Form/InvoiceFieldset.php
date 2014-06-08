<?php
namespace Ajasta\Invoice\Form;

use Ajasta\Invoice\Entity\Invoice;
use Zend\Filter\Null as NullFilter;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class InvoiceFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('invoice');
    }

    public function init()
    {
        parent::init();

        $this->setObject(new Invoice());

        $this->add([
            'name' => 'client',
            'type' => 'Ajasta\Client\Form\Element\ClientSelect',
            'options' => [
                'label' => 'Client',
                'column-size' => 'sm-4',
            ],
            'attributes' => [
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'project',
            'type' => 'select',
            'options' => [
                'label' => 'Project',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'locale',
            'type' => 'Ajasta\Core\Form\Element\LocaleSelect',
            'options' => [
                'label' => 'Language',
                'column-size' => 'sm-4',
            ],
            'attributes' => [
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'currencyCode',
            'type' => 'Ajasta\Core\Form\Element\CurrencySelect',
            'options' => [
                'label' => 'Currency',
                'column-size' => 'sm-4',
            ],
            'attributes' => [
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'issueDate',
            'type' => 'Ajasta\Core\Form\Element\DatePicker',
            'options' => [
                'label' => 'Issue date',
                'column-size' => 'sm-3',
                'default-today' => true,
            ],
            'attributes' => [
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'dueDate',
            'type' => 'Ajasta\Core\Form\Element\DatePicker',
            'options' => [
                'label' => 'Due date',
                'column-size' => 'sm-3',
            ],
        ]);

        $this->add([
            'name' => 'discount',
            'type' => 'number',
            'options' => [
                'label' => 'Discount',
                'column-size' => 'sm-2',
                'add-on-append' => '%',
            ],
            'attributes' => [
                'min' => '0',
                'max' => '100',
                'step' => '0.01',
            ],
        ]);

        $this->add([
            'name' => 'vat',
            'type' => 'number',
            'options' => [
                'label' => 'VAT',
                'column-size' => 'sm-2',
                'add-on-append' => '%',
            ],
            'attributes' => [
                'min' => '0',
                'max' => '100',
                'step' => '0.01',
            ],
        ]);

         $this->add([
             'name' => 'items',
             'type' => 'collection',
             'options' => [
                 'label' => 'Items',
                 'count' => 1,
                 'should_create_template' => true,
                 'target_element' => [
                     'type' => 'Ajasta\Invoice\Form\InvoiceItemFieldset',
                 ],
             ],
             'attributes' => [
                 'id' => 'invoiceItems',
             ],
         ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'client' => [
                'required' => true,
            ],
            'project' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => NullFilter::TYPE_STRING]],
                ],
            ],
            'locale' => [
                'required' => true,
            ],
            'currencyCode' => [
                'required' => true,
            ],
            'issueDate' => [
                'required' => true,
            ],
            'discount' => [
                'allow_empty' => true,
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => NullFilter::TYPE_STRING]],
                ],
            ],
            'vat' => [
                'allow_empty' => true,
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => NullFilter::TYPE_STRING]],
                ],
            ],
        ];
    }
}
