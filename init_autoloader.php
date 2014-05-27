<?php
if (!file_exists('vendor/autoload.php')) {
    throw new RuntimeException('Autoloader not found. Run `composer.phar install`.');
}

include 'vendor/autoload.php';
