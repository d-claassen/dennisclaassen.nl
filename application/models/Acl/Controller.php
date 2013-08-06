<?php

class Application_Model_Acl_Controller extends Application_Model_Abstract
{
	protected $id = '',
		$controller = '';

	public function reset()
	{
		$this->setId( null );
		$this->setController( null );
	}

	public function __toString()
	{
		return $this->getController();
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

	public function getController()
	{
		return $this->controller;
	}

	public function setController($controller)
	{
		$this->controller = $controller;
		return $this;
	}
}