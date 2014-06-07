<?php
namespace Ajasta\Client\Form;

use Ajasta\Client\Entity\Client;
use Zend\Filter\Null as NullFilter;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ClientFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('client');
    }

    public function init()
    {
        parent::init();

        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setObject(new Client());

        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Name',
                'column-size' => 'sm-4',
            ],
            'attributes' => [
                'required' => true,
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
            'name' => 'taxable',
            'type' => 'Ajasta\Core\Form\Element\Toggle',
            'options' => [
                'label' => 'Taxable',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'defaultUnit',
            'type' => 'Ajasta\Core\Form\Element\UnitSelect',
            'options' => [
                'label' => 'Default unit',
                'column-size' => 'sm-2',
            ],
        ]);

        $this->add([
            'name' => 'defaultUnitPrice',
            'type' => 'number',
            'options' => [
                'label' => 'Default unit price',
                'column-size' => 'sm-2',
            ],
            'attributes' => [
                'min' => '0',
                'step' => '0.01',
            ],
        ]);

        $this->add([
            'type' => 'Ajasta\Address\Form\AddressFieldset',
            'name' => 'address',
            'options' => [
                'label' => 'Address'
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'name' => [
                'required' => true,
            ],
            'locale' => [
                'required' => true,
            ],
            'currencyCode' => [
                'required' => true,
            ],
            'taxable' => [
                'required' => true,
            ],
            'defaultUnit' => [
                'allow_empty' => true,
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => NullFilter::TYPE_STRING]],
                ],
            ],
            'defaultUnitPrice' => [
                'allow_empty' => true,
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => NullFilter::TYPE_STRING]],
                ],
            ],
        ];
    }
}
