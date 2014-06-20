<?php
namespace Ajasta\Invoice\Printer;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoicePrinterFactory implements FactoryInterface
{
    /**
     * @return InvoicePrinter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new InvoicePrinter(
            $serviceLocator->get('Ajasta\Core\Printer\FopPrinter'),
            $serviceLocator->get('Ajasta\Invoice\Options')->getXslPath()
        );
    }
}
