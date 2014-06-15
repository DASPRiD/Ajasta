<?php
namespace Ajasta\Core\Form\View\Helper;

use TwbBundle\Form\View\Helper\TwbBundleFormElement;
use Zend\Form\ElementInterface;

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
