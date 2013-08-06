<?php

class Application_Model_Acl extends Zend_Acl
{
	public static $instance;

	static public function getInstance()
	{
		if( is_null( self::$instance ) )
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function load()
	{
		$this->loadRoles();
		$this->loadRights();
	}

	public function loadRoles()
	{
		$roleMapper = new Application_Model_Mapper_Acl_Role();
		$roles = $roleMapper->getRoles();

		foreach( $roles as $role )
		{
			$this->addRole( $role, $role->getParent() );
		}
	}

	public function loadResources($rights)
	{
		foreach( $rights as $right )
		{
			$resource = new Application_Model_Acl_Resource( $right );
			if ( !$this->has( $resource ) )
			{
				$this->addResource( $resource );
			}
		}
	}

	public function loadRights()
	{
		$resourceMapper = new Application_Model_Mapper_Acl();
		$rights = $resourceMapper->getRights();
		 
		$this->loadResources( $rights );
		 
		foreach( $rights as $right )
		{
			switch ( $right[ 'type' ] )
			{
				case Application_Model_Acl_Right::ALLOW:
					$this->allow( $right[ 'role' ], new Application_Model_Acl_Resource( $right ), $right[ 'action' ] );
					break;
				case Application_Model_Acl_Right::DENY:
					$this->deny( $right[ 'role' ], new Application_Model_Acl_Resource( $right ), $right[ 'action' ] );
					break;
				default:
					throw new Application_Exception( 'Type for ACL right was not recognized: ' . $right['type'] );
			}
		}
	}
}