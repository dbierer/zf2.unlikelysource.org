<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
if (stripos($_SERVER['HTTP_HOST'], 'local')) {
    define('APP_ENV', 'local');
} else {
    define('APP_ENV', 'production');
}
date_default_timezone_set('Europe/London');
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
chdir(dirname(__DIR__));
// Setup autoloading
require 'init_autoloader.php';
// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
