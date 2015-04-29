<?php
// 2015-03-19 DB: this is no longer used!!!
namespace DynamicAcl\Model;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Http\Header\Allow;
use Campuses\Model\Campuses;

class Acl extends ZendAcl
{
	public function __construct()
	{

		// resources = controllers or controller route mappings
		// 2015-03-11 DB: resources added from database
		//                Needed to add this as a default!
		$loginController = 'login-controller-index';
		$this->addResource($loginController);
		
	    // leave some hard-coded roles + rules to prevent possible total disaster
		$this
				->addRole('guest')

/////////////// All District groups inherit from everyone ///////
				->addRole('everyone', 'guest')      // everyone inherits from guest
				
/////////////// Super admin /////////////////////////////////////		
				->addRole('superadmin')
				;

        // guest can login and logout
        $this->allow('guest', $loginController);
        
        // superadmin can do anything
		$this->allow('superadmin');
	}
}