<?php
return array(
	'service_manager' => array(
		'aliases' => array(
			// defined in Application/config/module.config.php
			'DynamicAcl-auth-service'	=> 'ldap-auth-service',
		),
		'invokables' => array(
			'DynamicAcl-acl' => 'DynamicAcl\Model\Acl',
		),
	),
);