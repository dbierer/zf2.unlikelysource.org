<?php
/**
 * Local Configuration Override
 * Call the filename *.local.php and it will be read in
 * See application.config.php line 7
 *
 */

return array(
    'service_manager' => array(
        'factories' => array(
        	// uses the 'db' key by default
            'general-adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    	'services' => array(
		    /**
		     * Registration key
		     *
		     * Allows only users who enter the correct key to register through the website
		     *
		     * Accepted values: string
		     */
		    'registration-key' => array(''),
    		// comment out the item below and re-run http://zf2.unlikelysource.local/check
    		'check-test' => array('key' => 'FROM LOCAL.PHP', 'autoload/local.php:' . microtime()),
       	),
    ),
	// The 'db' key has special significance
    // look at the source code for Zend\Db\Adapter\AdapterServiceFactory
    // you will need to alter this to match your own database settings
    // NOTE: look in /docs/data.sql for the database structure
    'db' => array(
        'driver'         => 'pdo',
        'dsn'            => 'mysql:dbname=zf2_unlikelysource_org;host=localhost',
        'username'       => 'test',
        'password'       => 'password',
        'driver_options' => array(
        		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
        		// NOTE: change to PDO::ERRMODE_SILENT for production! 
        		PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING),
    ),
);
