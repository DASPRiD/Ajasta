<?php
namespace Ajasta\Invoice\Form;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoiceFieldsetFactory implements FactoryInterface
{
    /**
     * @return InvoiceFieldset
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }
        
        $fieldset = new InvoiceFieldset();
        $fieldset->setHydrator(
            $serviceLocator->get('hydratorManager')->get('Ajasta\Invoice\Hydrator\InvoiceHydrator')
        );

        return $fieldset;
    }
}
