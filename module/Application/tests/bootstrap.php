<?php
/**
 * bootstrap.php
 * 
 * Designed to be included in all unit tests for the application
 * NOTE: there is executable code at the top of this file!
 * 
 * @copyright Copyright (c) 2012 Etholutions, LLC. (http://www.ethoultions.net)
 * 
 */

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);
require __DIR__ . '/../../../tests/TestBootstrap.php';

/**
 * TestBootstrap::init('ModuleName' [, array('Modules','In_Order')])
 */
TestBootstrap::init('Application');
