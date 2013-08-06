<?php

class Application_Model_Acl_Resource extends Zend_Acl_Resource
{
	protected $controller = '',
	$module = '';

	public function __construct(array $options = null)
	{
		if (is_array($options))
		{
			$this->setOptions($options);
		}
	}

	public function __set($name, $value)
	{
		$method = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $name)));
		if (('mapper' == $name) || !method_exists($this, $method))
		{
			throw new Exception('Invalid item property');
		}
		$this->$method($value);
	}

	public function __get($name)
	{
		$method = 'get' . str_replace(" ", "", ucwords(str_replace("_", " ", $name)));
		if (('mapper' == $name) || !method_exists($this, $method))
		{
			throw new Exception('Invalid item property');
		}
		return $this->$method();
	}

	public function setOptions(array $options)
	{
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $key)));
			if (in_array($method, $methods))
			{
				$this->$method($value);
			}
		}
		return $this;
	}

	public function getController()
	{
		return $this->controller;
	}

	public function setController($controller)
	{
		$this->controller = $controller;
		$this->setResourceId();
		return $this;
	}

	public function getModule()
	{
		return $this->module();
	}

	public function setModule($module)
	{
		$this->module = $module;
		$this->setResourceId();
		return $this;
	}

	private function setResourceId()
	{
		$resource = (!empty($this->_resourceId)) ? explode($this->_resourceId, ':') : array();
		$resource[0] = $this->module;
		$resource[1] = $this->controller;
		$this->_resourceId = implode($resource, ':');
	}
}