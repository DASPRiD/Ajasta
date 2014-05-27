<?php
namespace Application\Form;

use Application\Entity\Client;
use Application\Hydrator\ClientHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ClientFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ClientHydrator $clientHydrator)
    {
        parent::__construct('client');

        $this->setHydrator($clientHydrator);
    }

    public function init()
    {
        parent::init();

        $this->setObject(new Client());

        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Full name',
                'column-size' => 'sm-4',
            ],
            'attributes' => [
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'locale',
            'type' => 'Application\Form\Element\LocaleSelect',
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
            'type' => 'Application\Form\Element\CurrencySelect',
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
            'type' => 'Application\Form\Element\Toggle',
            'options' => [
                'label' => 'Taxable',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'defaultUnit',
            'type' => 'Application\Form\Element\UnitSelect',
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
            'type' => 'Application\Form\AddressFieldset',
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
            'defaultUnitPrice' => [
                'allow_empty' => true,
            ],
        ];
    }
}
