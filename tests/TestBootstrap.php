<?php
/**
 * bootstrap.php
 * 
 * Designed to be included in all unit tests for the application
 * Normally only one module will be loaded for a test
 * If you have other modules which need to be loaded, make sure
 * that the test bootstrap.php calls TestBootstrap::setOtherModules($array_of_module_names)
 * 
 * @copyright Copyright (c) 2012 Etholutions, LLC. (http://www.ethoultions.net)
 * 
 */

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;

class TestBootstrap
{
	public static $moduleName        = NULL;
	protected static $otherModules   = NULL;
	protected static $serviceManager = NULL;
	protected static $config		 = NULL;
	protected static $bootstrap      = NULL;

	/**
	 * Initializes test environment
	 * @param string $moduleName
	 * @param array $modulesToBeLoaded (only used if > 1 module to be loaded)
	 */
	public static function init($moduleName, $modulesToBeLoaded = NULL)
	{
		// assign module name
		self::$moduleName = $moduleName;
		
		// load main app config file
		$testConfig = require __DIR__ . '/config/application.config.php';
		
		// override 'modules' key
		unset($testConfig['modules']);

		// load other modules (if defined)
		if ($modulesToBeLoaded) {
			foreach($modulesToBeLoaded as $item) {
				$testConfig['modules'][] = $item;
			}
		} else {
			// just load one module
			$testConfig['modules'] = array(self::$moduleName);
		}
		
		// load the module and set up test autoloading
		$zf2ModulePaths = array();

		if (isset($testConfig['module_listener_options']['module_paths'])) {
			$modulePaths = $testConfig['module_listener_options']['module_paths'];
			foreach ($modulePaths as $modulePath) {
				if (($path = static::findParentPath($modulePath))) {
					$zf2ModulePaths[] = $path;
				}
			}
		}

		$zf2ModulePaths = implode(PATH_SEPARATOR, $zf2ModulePaths) . PATH_SEPARATOR;
		$zf2ModulePaths .= getenv('ZF2_MODULES_TEST_PATHS') ? : (defined('ZF2_MODULES_TEST_PATHS') ? ZF2_MODULES_TEST_PATHS : '');

		static::initAutoloader();

		// use ModuleManager to load this module and it's dependencies
		$baseConfig = array(
			'module_listener_options' => array(
				'module_paths' => explode(PATH_SEPARATOR, $zf2ModulePaths),
			),
		);

		$config = ArrayUtils::merge($baseConfig, $testConfig);

		$serviceManager = new ServiceManager(new ServiceManagerConfig());
		$serviceManager->setService('ApplicationConfig', $config);
		$serviceManager->get('ModuleManager')->loadModules();
		$config = $serviceManager->get('Config');
		//var_dump($config); exit;
		static::$serviceManager = $serviceManager;
		static::$config = $config;
	}

	public static function setOtherModules(array $otherModules)
	{
		static::$otherModules = $otherModules;
	}

	public static function findParentPath($path)
	{
		return realpath(__DIR__ . '/../' . $path);
	}

	public static function getServiceManager()
	{
		return static::$serviceManager;
	}

	public static function getConfig()
	{
		return static::$config;
	}

	protected static function initAutoloader()
	{
		$vendorPath = __DIR__ . '/../vendor';

		if (is_readable($vendorPath . '/autoload.php')) {
			$loader = include $vendorPath . '/autoload.php';
		} else {
			$zf2Path = getenv('ZF2_PATH') ? : (defined('ZF2_PATH') ? ZF2_PATH : (is_dir($vendorPath . '/ZF2/library') ? $vendorPath . '/ZF2/library' : false));

			if (!$zf2Path) {
				throw new Exception('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
			}

			include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';

		}

		AutoloaderFactory::factory(array(
			'Zend\Loader\StandardAutoloader' => array(
				'autoregister_zf' => true,
				'namespaces' => array(
					self::$moduleName . 'Test' => __DIR__ . '/../module/' . self::$moduleName . '/tests/' . self::$moduleName . 'Test',
					self::$moduleName          => __DIR__ . '/../module/' . self::$moduleName . '/src/' . self::$moduleName,
				),
			),
		));
	}

}
