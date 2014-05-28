<?php
namespace Ajasta\I18n;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../../../config/module.config.php';
    }
}
