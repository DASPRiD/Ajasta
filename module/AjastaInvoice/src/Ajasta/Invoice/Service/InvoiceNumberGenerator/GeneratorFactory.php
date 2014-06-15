<?php
namespace Ajasta\Invoice\Service\InvoiceNumberGenerator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GeneratorFactory implements FactoryInterface
{
    /**
     * @return GeneratorInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new FormatGenerator(
            $serviceLocator->get('Ajasta\Invoice\Options')->getInvoiceNumberFormat()
        );
    }
}
