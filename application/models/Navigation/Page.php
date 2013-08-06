<?php

class Application_Model_Navigation_Page extends Zend_Navigation_Page_Mvc implements Application_Model_Interface
{
	protected $_parent_id = null;

	/**
	 *
	 * Required for saving pages
	 */
	const IDENTIFIER_FIELD = 'id';

	public function __construct(array $options = null)
	{
		if (is_array($options))
		{
			$this->setOptions($options);
		}
	}

	public function __set($name, $value)
	{
		$method = 'set' . str_replace( " ", "", ucwords( str_replace( "_", " ", $name ) ) );
		if( ( 'mapper' == $name ) || !method_exists( $this, $method ) )
		{
			throw new Exception( 'Invalid item property' );
		}
		return $this->$method( $value );
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
				$this->$method( $value );
			}
		}
		return $this;
	}

  public function toArray()
  {
    return array_merge( parent::toArray(), array(
        'parent_id' => $this->getParentId()
      ) );
  }
	
	public function toSaveArray()
	{
		return array(
			'parent_id' => $this->getParentId(),
			'label' => $this->getLabel(),
			'module' => $this->getModule(),
			'controller' => $this->getController(),
			'action' => $this->getAction(),
			'visible' => $this->getVisible()
		);
	}

	public function reset()
	{
		
	}

	public function setLabel( $label )
	{
		// Force the usage of UTF-8
		$label = utf8_encode( html_entity_decode( $label ) );
		return parent::setLabel( $label );
	}

	public function getParentId()
	{
		return $this->_parent_id;
	}

	public function setParentId($parent_id)
	{
		$this->_parent_id = $parent_id;
		return $this;
	}
	
	public function setModule( $module )
	{
		parent::setModule( $module );
		$this->setResource( $module . ':' . $this->getController() );
	}

	public function setController( $controller )
	{
		parent::setController( $controller );
		$this->setResource( $this->getModule() . ':' . $controller );
	}
	
	public function setAction( $action )
	{
		parent::setAction( $action );
		$this->setPrivilege( $action );
	}
	
	public function save()
	{
		// Make sure the Page exists as a Resource


		$mapper = new Application_Model_Mapper_Navigation();
		$mapper->save( $this );
	}

	public function delete()
	{
		$mapper = new Application_Model_Mapper_Navigation();
		$mapper->delete( $this );
	}
}