<?php

$configFile = __DIR__ . '/../../module/Zf2f/config/labs_and_classes.ini';
$configReader = new Zend\Config\Reader\Ini();
$config = $configReader->fromFile($configFile);
return ['service_manager' => ['services' => $config]];

/*
return [ 
	'service_manager' => [
		'services' => [
			'zf2f-config' => [
				'class' => [
					'20130722' => '20130722',
				],
				'notes' => [
					'mod_02' => 'Module 2 (Project) LAB SETUP NOTES',
					'mod_03' => 'Module 3 (Events) LAB SETUP NOTES',
					'mod_04' => 'Module 4 (Services) LAB SETUP NOTES',
				],
				'solutions' => [
					'mod_03' => 'Module 3 (Events) LAB SOLUTIONS',
					'mod_04' => 'Module 4 (Services) LAB SOLUTIONS',
				],
			],
		],
	],
];
*/