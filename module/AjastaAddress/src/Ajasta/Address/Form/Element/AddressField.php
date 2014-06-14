<?php
namespace Ajasta\Address\Form\Element;

use Zend\Filter\Null as NullFilter;
use Zend\Form\Element\Text;
use Zend\InputFilter\InputFilterProviderInterface;

class AddressField extends Text implements InputFilterProviderInterface
{
    public function getInputFilterSpecification()
    {
        return [
            'validators' => [
                [
                    'name' => 'Ajasta\Address\Validator\AddressFieldValidator',
                    'options' => ['field' => $this->getName()]
                ],
            ],
            'filters' => [
                ['name' => 'stringtrim'],
                ['name' => 'null', 'options' => ['type' => NullFilter::TYPE_STRING]],
            ],
            'required' => true,
            'continue_if_empty' => true,
        ];
    }
}
