<?php
// see http://framework.zend.com/manual/2.2/en/modules/zend.service-manager.delegator-factories.html
return array(
    /*
    'service_manager' => array(
    
    ),
    */
    'navigation' => array(
        'default' => array(
    	   array('label' => 'SvcMgr', 'route' => 'service-manager-demo', 'order' => 1600),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'service-manager-demo-controller-index' => 'ServiceManagerDemo\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'service-manager-demo' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/service-manager-demo',
                    'defaults' => array(
                        'controller'    => 'service-manager-demo-controller-index',
                        'action'        => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ServiceManagerDemo' => __DIR__ . '/../view',
        ),
    ),
);
