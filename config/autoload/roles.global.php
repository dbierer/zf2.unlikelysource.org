<?php
// 2015-02-11 DB: added "roles" key as a service manager service
// DO NOT CONFUSE GROUPS WITH ROLES
// if you want to associate a group with a role, use the GROUPS table in the Groups module
return array(
    'service_manager' => array(
        'services' => array(
            // 2015-03-19 DB
            // lists the roles and their labels
            // -- key = role
            // -- value = 'label => appears in dropdown menus; 'parent' => role(s) the key role inherits from
            'roles' => array(
                'guest'          => array('label' => 'Guest',           'parent' => array()),
                'everyone'       => array('label' => 'Everyone',        'parent' => array('guest')),
                'businessoffice' => array('label' => 'Business Office', 'parent' => array('everyone')),
                'reporting'      => array('label' => 'Reporting',       'parent' => array('everyone')),
                'admins'         => array('label' => 'Admin',           'parent' => array('everyone')),
                'superadmin'     => array('label' => 'Super Admin',     'parent' => array('admins')),
            ),
        ),
    ),  
);