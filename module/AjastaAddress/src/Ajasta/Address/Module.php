<?php
namespace Ajasta\Address;

use Zend\Console\Adapter\AdapterInterface as Console;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../../../config/module.config.php';
    }

    public function getConsoleBanner(Console $console)
    {
        return
            "---------------------\n" .
            " AjastaAddress usage \n" .
            "---------------------\n" .
            " php public/index.php ajasta address update-address-formats\n"
        ;
    }
}
