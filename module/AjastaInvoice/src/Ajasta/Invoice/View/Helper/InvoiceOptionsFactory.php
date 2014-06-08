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
        $config = $viewHelperManager->getServiceLocator()->get('Config')['ajasta']['invoice'];

        return new InvoiceOptions(
            $config['default_vat'],
            $config['default_unit'],
            $config['default_unit_price']
        );
    }
}
