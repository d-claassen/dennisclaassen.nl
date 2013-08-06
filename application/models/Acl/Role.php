<?php

class Application_Model_Acl_Role extends Zend_Acl_Role
{
	protected $id = '',
		$parent = null;

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

	public function toArray()
	{
		return array(
    		'id' => $this->getId(),
    		'name' => $this->getName(),
    		'parent' => $this->getParent()
		);
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

	public function getName()
	{
		return $this->getRoleId();
	}

	public function setName($name)
	{
		$this->_roleId = $name;
		return $this;
	}

	public function getParent()
	{
		return $this->parent;
	}

	public function setParent($parent)
	{
		if( is_string( $parent ) && strlen( $parent ) > 0 )
		{
			$this->parent = $parent;
		}
		return $this;
	}
	
	public function save()
	{
		$mapper = new Application_Model_Mapper_Acl_Role();
		$mapper->save( $this );
	}
}