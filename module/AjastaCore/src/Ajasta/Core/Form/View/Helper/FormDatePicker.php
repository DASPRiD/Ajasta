<?php
namespace Ajasta\Core\Form\View\Helper;

use Zend\Form\ElementInterface;
use TwbBundle\Form\View\Helper\TwbBundleFormElement;

class FormDatePicker extends TwbBundleFormElement
{
    public function render(ElementInterface $element)
    {
        $element->setAttribute('data-role', 'datepicker');

        if ($element->getOption('default-today')) {
            $element->setAttribute('data-default-today', 'true');
        }

        return parent::render($element);
    }
}
