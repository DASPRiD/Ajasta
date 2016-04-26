<?php
// Delegate static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server'
    && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/* @var  $container \Interop\Container\ContainerInterface */
$container = require 'config/container.php';

/* @var  $application \Zend\Expressive\Application */
$application = $container->get('Zend\Expressive\Application');
$application->run();
