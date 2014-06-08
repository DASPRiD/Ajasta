<?php
namespace Ajasta\Invoice\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoiceFieldsetFactory implements FactoryInterface
{
    /**
     * @return InvoiceFieldset
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $hydratorManager = $formElementManager->getServiceLocator()->get('hydratorManager');

        $fieldset = new InvoiceFieldset();
        $fieldset->setHydrator($hydratorManager->get('Ajasta\Invoice\Hydrator\InvoiceHydrator'));

        return $fieldset;
    }
}
