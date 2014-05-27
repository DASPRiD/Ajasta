<?php
namespace Application\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressFormatFactory implements FactoryInterface
{
    /**
     * @return AddressFormat
     */
    public function createService(ServiceLocatorInterface $viewHelperManager)
    {
        return new AddressFormat(
            $viewHelperManager->getServiceLocator()->get('Application\Service\AddressService')
        );
    }
}