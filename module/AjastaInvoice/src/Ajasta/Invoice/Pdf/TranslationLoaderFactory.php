<?php
namespace Ajasta\Invoice\Pdf;

use Ajasta\Core\Printer\TranslationLoader;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TranslationLoaderFactory implements FactoryInterface
{
    /**
     * @return TranslationLoader
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new TranslationLoader(
            $serviceLocator->get('Ajasta\Invoice\Options')->getTranslationPath()
        );
    }
}
