<?php
namespace Ajasta\Invoice\Form;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

class InvoiceFieldsetFactory implements FactoryInterface
{
    /**
     * @return InvoiceFieldset
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        /* @var $hydratorManager HydratorPluginManager */
        $hydratorManager = $serviceLocator->get('HydratorManager');
        /* @var $invoiceHydrator HydratorInterface */
        $invoiceHydrator = $hydratorManager->get('Ajasta\Invoice\Hydrator\InvoiceHydrator');

        $fieldset = new InvoiceFieldset();
        $fieldset->setHydrator($invoiceHydrator);

        return $fieldset;
    }
}
