<?php

class Application_Model_Acl_Right extends Application_Model_Abstract
{
	const ALLOW = 'allow',
		DENY = 'deny',
		IDENTIFIER_KEY = 'role_id, module_id, controller_id, action_id';

	protected $role_id = '',
		$module_id = '',
		$controller_id = '',
		$action_id = '',
		$type = self::ALLOW;

	public function reset()
	{
		$this->setRoleId( null );
    	$this->setModuleId( null );
    	$this->setControllerId( null );
    	$this->setActionId( null );
    	$this->setType( null );
	}
		
	public function getRoleId()
	{
		return $this->role_id;
	}

	public function setRoleId($role_id)
	{
		$this->role_id = $role_id;
		return $this;
	}

	public function getModuleId()
	{
		return $this->module_id;
	}

	public function setModuleId($module_id)
	{
		$this->module_id = $module_id;
		return $this;
	}

	public function getControllerId()
	{
		return $this->controller_id;
	}

	public function setControllerId($controller_id)
	{
		$this->controller_id = $controller_id;
		return $this;
	}

	public function getActionId()
	{
		return $this->action_id;
	}

	public function setActionId($action_id)
	{
		$this->action_id = $action_id;
		return $this;
	}

	public function getType()
	{
		return $this->type;
	}

	public function setType($type)
	{
		$this->type = $type;
		return $this;
	}
}