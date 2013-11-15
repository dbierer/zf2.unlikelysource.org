<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
date_default_timezone_set('Europe/London');
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
chdir(dirname(__DIR__));
// Setup autoloading
if (file_exists('vendor/ZF2/library/Zend/Loader/AutoloaderFactory.php')) {
    include 'vendor/ZF2/library/Zend/Loader/AutoloaderFactory.php';
} else {
    include '/var/www/ZF2/library/Zend/Loader/AutoloaderFactory.php';
}
Zend\Loader\AutoloaderFactory::factory(array(
    'Zend\Loader\StandardAutoloader' => array(
        'autoregister_zf' => true
    )
));
// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
