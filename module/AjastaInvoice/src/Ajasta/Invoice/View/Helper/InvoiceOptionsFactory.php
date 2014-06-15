<?php
namespace Ajasta\Invoice\View\Helper;

use Ajasta\Core\FactoryUtils;
use Ajasta\Invoice\Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoiceOptionsFactory implements FactoryInterface
{
    /**
     * @return InvoiceOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        /* @var $options Options */
        $options = $serviceLocator->get('Ajasta\Invoice\Options');

        return new InvoiceOptions($options);
    }
}
