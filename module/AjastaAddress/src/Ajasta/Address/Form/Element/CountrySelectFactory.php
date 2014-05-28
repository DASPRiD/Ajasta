<?php
namespace Ajasta\Address\Form\Element;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CountrySelectFactory implements FactoryInterface
{
    /**
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $serviceLocator = $formElementManager->getServiceLocator();

        return new CountrySelect(
            $serviceLocator->get('Ajasta\Address\Service\AddressService'),
            $serviceLocator->get('Ajasta\I18n\Cldr\Manager')
        );
    }
}