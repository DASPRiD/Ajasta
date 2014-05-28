<?php
namespace Ajasta\Address\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressServiceFactory implements FactoryInterface
{
    /**
     * @return AddressService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['address_formats'];

        return new AddressService(
            $config['data_path'],
            $config['locale_data_uri'],
            $config['country_codes']
        );
    }
}
