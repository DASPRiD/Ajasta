<?php
namespace Ajasta\Address\Form;

use Ajasta\Address\Entity\Address;
use Ajasta\Address\Hydrator\AddressHydrator;
use Zend\Filter\Null;
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
            'type' => 'text',
            'options' => [
                'label' => 'Recipient',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'organization',
            'type' => 'text',
            'options' => [
                'label' => 'Organization',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'addressLine1',
            'type' => 'text',
            'options' => [
                'label' => 'Address line 1',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'addressLine2',
            'type' => 'text',
            'options' => [
                'label' => 'Address line 2',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'locality',
            'type' => 'text',
            'options' => [
                'label' => 'Locality',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'dependentLocality',
            'type' => 'text',
            'options' => [
                'label' => 'Dependent locality',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'administrativeArea',
            'type' => 'text',
            'options' => [
                'label' => 'Administrative area',
                'column-size' => 'sm-4',
            ],
        ]);

        $this->add([
            'name' => 'postalCode',
            'type' => 'text',
            'options' => [
                'label' => 'Postal code',
                'column-size' => 'sm-2',
            ],
        ]);

        $this->add([
            'name' => 'sortingCode',
            'type' => 'text',
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
            'recipient' => [
                'validators' => [
                    ['name' => 'Ajasta\Address\Validator\AddressFieldValidator', 'options' => ['field' => 'recipient']],
                ],
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => Null::TYPE_STRING]],
                ],
                'required' => true,
                'continue_if_empty' => true,
            ],
            'organization' => [
                'validators' => [
                    ['name' => 'Ajasta\Address\Validator\AddressFieldValidator', 'options' => ['field' => 'organization']],
                ],
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => Null::TYPE_STRING]],
                ],
                'required' => true,
                'continue_if_empty' => true,
            ],
            'addressLine1' => [
                'validators' => [
                    ['name' => 'Ajasta\Address\Validator\AddressFieldValidator', 'options' => ['field' => 'addressLine1']],
                ],
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => Null::TYPE_STRING]],
                ],
                'required' => true,
                'continue_if_empty' => true,
            ],
            'addressLine2' => [
                'validators' => [
                    ['name' => 'Ajasta\Address\Validator\AddressFieldValidator', 'options' => ['field' => 'addressLine2']],
                ],
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => Null::TYPE_STRING]],
                ],
                'required' => true,
                'continue_if_empty' => true,
            ],
            'locality' => [
                'validators' => [
                    ['name' => 'Ajasta\Address\Validator\AddressFieldValidator', 'options' => ['field' => 'locality']],
                ],
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => Null::TYPE_STRING]],
                ],
                'required' => true,
                'continue_if_empty' => true,
            ],
            'dependentLocality' => [
                'validators' => [
                    ['name' => 'Ajasta\Address\Validator\AddressFieldValidator', 'options' => ['field' => 'dependentLocality']],
                ],
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => Null::TYPE_STRING]],
                ],
                'required' => true,
                'continue_if_empty' => true,
            ],
            'administrativeArea' => [
                'validators' => [
                    ['name' => 'Ajasta\Address\Validator\AddressFieldValidator', 'options' => ['field' => 'administrativeArea']],
                ],
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => Null::TYPE_STRING]],
                ],
                'required' => true,
                'continue_if_empty' => true,
            ],
            'postalCode' => [
                'validators' => [
                    ['name' => 'Ajasta\Address\Validator\AddressFieldValidator', 'options' => ['field' => 'postalCode']],
                ],
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => Null::TYPE_STRING]],
                ],
                'required' => true,
                'continue_if_empty' => true,
            ],
            'sortingCode' => [
                'validators' => [
                    ['name' => 'Ajasta\Address\Validator\AddressFieldValidator', 'options' => ['field' => 'sortingCode']],
                ],
                'filters' => [
                    ['name' => 'null', 'options' => ['type' => Null::TYPE_STRING]],
                ],
                'required' => true,
                'continue_if_empty' => true,
            ],
            'countryCode' => [
                'required' => true,
            ],
        ];
    }
}