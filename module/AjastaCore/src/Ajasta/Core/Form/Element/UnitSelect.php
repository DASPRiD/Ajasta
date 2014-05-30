<?php
namespace Ajasta\Core\Form\Element;

use Zend\Filter\Null as NullFilter;
use Zend\Form\Element\Select;

class UnitSelect extends Select
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setValueOptions([
            ''      => 'None',
            'hours' => 'Hours',
            'days'  => 'Days',
        ]);
    }

    public function getInputSpecification()
    {
        $spec = parent::getInputSpecification();
        $spec['allow_empty'] = true;
        $spec['filters'] = [new NullFilter(NullFilter::TYPE_STRING)];

        return $spec;
    }
}
