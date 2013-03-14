<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
ini_set('display_errors', 1);
chdir(dirname(__DIR__));
// Setup autoloading
$zf2Path = 'vendor/ZF2/library';
include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array(
    'Zend\Loader\StandardAutoloader' => array(
        'autoregister_zf' => true
    )
));
// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
