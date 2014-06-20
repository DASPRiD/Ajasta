<?php
namespace Ajasta\Invoice\Pdf;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class XmlGeneratorFactory implements FactoryInterface
{
    /**
     * @return XmlGenerator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new XmlGenerator(
            $serviceLocator->get('Ajasta\Address\Service\AddressService'),
            $serviceLocator->get('Ajasta\I18n\Formatter\Unit'),
            $serviceLocator->get('Ajasta\Invoice\Printer\TranslationLoader'),
            realpath(__DIR__ . '/../../../../data/invoice.xsd'),
            $serviceLocator->get('Ajasta\Invoice\Options')->getDateType()
        );
    }
}
