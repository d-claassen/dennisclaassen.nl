<?php

class Application_Model_User extends Application_Model_Abstract
{
	const IDENTIFIER_KEY = 'id',
		DEFAULT_ROLE = 'guest';

	protected $id = '',
		$username = '',
		$real_name = '',
		$role_id = '',
		$role = self::DEFAULT_ROLE;

	public function getId()
	{
		return $this->id;
	}

	public function setId( $id)
	{
		$this->id = $id;
		return $this;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setUsername( $username)
	{
		$this->username = $username;
		return $this;
	}

	public function getRealName()
	{
		return $this->real_name;
	}

	public function setRealName( $real_name)
	{
		$this->real_name = $real_name;
		return $this;
	}

	public function getRoleId()
	{
		return $this->role_id;
	}

	public function setRoleId( $role_id)
	{
		$this->role_id = $role_id;
		return $this;
	}

	public function getRole()
	{
		return $this->role;
	}

	public function setRole( $role )
	{
		$this->role = $role;
		return $this;
	}

	public function reset()
	{
		$this->setId( '' )
			->setUsername( '' )
			->setRealName( '' )
			->setRoleId( '' )
			->setRole( self::DEFAULT_ROLE );
		return $this;
	}

	public function loadUserByUsername( $username )
	{
		$user = $this->_mapper->getUserBy( 'username', $username );
		$this->setOptions( $user->toArray() );
		return $this;
	}

	public function isLoggedIn()
	{
		return $this->_role !== self::DEFAULT_ROLE;
	}

	public function getUrl()
	{
		// need a view for the url helper function
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper( 'viewRenderer' );
		if ( $viewRenderer->view === null )
		{
			$viewRenderer->initView();
		}
		$view = $viewRenderer->view;

		return $view->url( array(
				'controller' => 'user',
				'action' => 'view',
				'id' => $this->getId()
			), 'default' );
	}
}