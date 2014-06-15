<?php
namespace Ajasta\Invoice\Datatable;

use IntlDateFormatter;
use Locale;
use NumberFormatter;
use Zend\Escaper\Escaper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FormatterFactory implements FactoryInterface
{
    /**
     * @return Formatter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Formatter(
            new Escaper(),
            new IntlDateFormatter(Locale::getDefault(), IntlDateFormatter::MEDIUM, IntlDateFormatter::NONE),
            new NumberFormatter(Locale::getDefault(), NumberFormatter::CURRENCY),
            $serviceLocator->get('HttpRouter')
        );
    }
}
