<?php
namespace Ajasta\Application\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormCheckbox;

class FormToggle extends FormCheckbox
{
    public function render(ElementInterface $element)
    {
        $element->setAttribute('class', 'checkbox-toggle');

        return parent::render($element);
    }
}
