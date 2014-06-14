<?php
namespace Ajasta\Address\Form;

use Ajasta\Address\Entity\Address;
use Ajasta\Address\Hydrator\AddressHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class AddressFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(AddressHydrator $addressHydrator)
    {
        parent::__construct('address');

        $this->setHydrator($addressHydrator);
    }

    public function init()
    {
        parent::init();

        $this->setObject(new Address());

        $this->add([
            'name' => 'recipient',
            'type' => 'Ajasta\Address\Form\Element\AddressField',
            'options' => [
                'label' => 'Recipient',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'organization',
            'type' => 'Ajasta\Address\Form\Element\AddressField',
            'options' => [
                'label' => 'Organization',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'addressLine1',
            'type' => 'Ajasta\Address\Form\Element\AddressField',
            'options' => [
                'label' => 'Address line 1',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'addressLine2',
            'type' => 'Ajasta\Address\Form\Element\AddressField',
            'options' => [
                'label' => 'Address line 2',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'locality',
            'type' => 'Ajasta\Address\Form\Element\AddressField',
            'options' => [
                'label' => 'Locality',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'dependentLocality',
            'type' => 'Ajasta\Address\Form\Element\AddressField',
            'options' => [
                'label' => 'Dependent locality',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'administrativeArea',
            'type' => 'Ajasta\Address\Form\Element\AddressField',
            'options' => [
                'label' => 'Administrative area',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'postalCode',
            'type' => 'Ajasta\Address\Form\Element\AddressField',
            'options' => [
                'label' => 'Postal code',
                'column-size' => 'sm-2',
            ],
        ]);

        $this->add([
            'name' => 'sortingCode',
            'type' => 'Ajasta\Address\Form\Element\AddressField',
            'options' => [
                'label' => 'Sorting code',
                'column-size' => 'sm-2',
            ],
        ]);

        $this->add([
            'name' => 'countryCode',
            'type' => 'Ajasta\Address\Form\Element\CountrySelect',
            'options' => [
                'label' => 'Country',
                'column-size' => 'sm-4',
            ],
            'attributes' => [
                'required' => true,
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'countryCode' => [
                'required' => true,
            ],
        ];
    }
}
