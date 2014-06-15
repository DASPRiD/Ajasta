<?php
namespace Ajasta\Invoice\Form;

use Ajasta\Core\FactoryUtils;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoiceFieldsetFactory implements FactoryInterface
{
    /**
     * @return InvoiceFieldset
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator  = FactoryUtils::resolveServiceLocator($serviceLocator);
        $hydratorManager = $serviceLocator->get('HydratorManager');

        $fieldset = new InvoiceFieldset();
        $fieldset->setHydrator($hydratorManager->get('Ajasta\Invoice\Hydrator\InvoiceHydrator'));

        return $fieldset;
    }
}
