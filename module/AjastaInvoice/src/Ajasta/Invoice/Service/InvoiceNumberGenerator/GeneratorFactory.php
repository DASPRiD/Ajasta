<?php
namespace Ajasta\Invoice\Service\InvoiceNumberGenerator;

use Ajasta\Invoice\Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GeneratorFactory implements FactoryInterface
{
    /**
     * @return GeneratorInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options Options*/
        $options = $serviceLocator->get('Ajasta\Invoice\Options');

        return new FormatGenerator($options->getInvoiceNumberFormat());
    }
}
