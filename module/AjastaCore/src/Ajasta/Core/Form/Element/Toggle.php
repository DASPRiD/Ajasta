<?php
namespace Ajasta\Core\Form\Element;

use Zend\Form\Element\Checkbox;

class Toggle extends Checkbox
{
    protected $attributes = [
        'type' => 'toggle',
    ];
}
