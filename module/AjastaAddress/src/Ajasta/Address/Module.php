<?php
namespace Ajasta\Address;

use Zend\Console\Adapter\AdapterInterface as ConsoleAdapter;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;

class Module implements
    ConfigProviderInterface,
    ConsoleBannerProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../../../config/module.config.php';
    }

    public function getConsoleBanner(ConsoleAdapter $console)
    {
        return
            "---------------------\n" .
            " AjastaAddress usage \n" .
            "---------------------\n" .
            " php public/index.php ajasta address update-address-formats\n"
        ;
    }
}
