<?php

class Application_Model_Acl_Module extends Application_Model_Abstract
{
	protected $id = '',
		$module = '';

	public function __toString()
	{
		return $this->getModule();
	}

	public function reset()
	{
		$this->setId( null );
    	$this->setModule( null );
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	public function getModule()
	{
		return $this->module;
	}

	public function setModule($module)
	{
		$this->module = $module;
		return $this;
	}
}