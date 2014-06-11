<?php
namespace Ajasta\Invoice\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoiceOptionsFactory implements FactoryInterface
{
    /**
     * @return InvoiceOptions
     */
    public function createService(ServiceLocatorInterface $viewHelperManager)
    {
        $options = $viewHelperManager->getServiceLocator()->get('Ajasta\Invoice\Options');

        return new InvoiceOptions(
            $options->getDefaultVat(),
            $options->getDefaultUnit(),
            $options->getDefaultUnitPrice()
        );
    }
}
