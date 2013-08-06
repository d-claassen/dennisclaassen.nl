<?php

class Application_Model_Acl_Action extends Application_Model_Abstract
{
	const IDENTIFIER_KEY = 'id';
	
	protected $id = '',
		$action = '';

	public function __toString()
	{
		return $this->getAction();
	}
	
	public function reset()
	{
		$this->setId( null );
		$this->setAction( null );
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

	public function getAction()
	{
		return $this->action;
	}

	public function setAction($action)
	{
		$this->action = $action;
		return $this;
	}
}