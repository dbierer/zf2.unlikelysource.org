<?php
return [
	'service_manager' => [
		'services' => [
		    'forum-captcha-options' => [
		    	'expiration' => 300,
		    	'font'		=> __DIR__ . '/../Fonts/FreeSansBold.ttf',
		    	'fontSize'	=> 24,
		    	'height'	=> 50,
		    	'width'		=> 200,
		    	'imgDir'	=> __DIR__ . '/../../public/captcha',
		    	'imgUrl'	=> '/captcha',
		    ],
		],
	],
];