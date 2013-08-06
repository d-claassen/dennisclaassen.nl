<?php

abstract class Application_Model_Abstract implements Application_Model_Interface
{
	protected $_mapper;

	const IDENTIFIER_FIELD = 'id';

	public function __construct( array $options = null )
	{
		if( is_array( $options ) )
		{
			$this->setOptions( $options );
		}

		$mapperName = str_replace( "Model", "Model_Mapper", get_class( $this ) );
		$mapper = new $mapperName();
		if( $mapper instanceof Application_Model_Mapper_Interface )
		{
			$this->_mapper = $mapper;
		}
	}

	public function __set( $name, $value )
	{
		$method = 'set' . str_replace( " ", "", ucwords( str_replace( "_", " ", $name ) ) );
		if( ( 'mapper' == $name ) || !method_exists( $this, $method ) )
		{
			throw new Application_Model_Exception( 'Invalid property [' . $name . '] for model [' . get_class( $this ) . ']', Application_Model_Exception::INVALID_PROPERTY );
		}
		$this->$method( $value );
	}

	public function __get( $name )
	{
		$method = 'get' . str_replace( " ", "", ucwords( str_replace( "_", " ", $name ) ) );
		if( ( 'mapper' == $name ) || !method_exists( $this, $method ) )
		{
			throw new Application_Model_Exception( 'Invalid property [' . $name . '] for model [' . get_class( $this ) . ']', Application_Model_Exception::INVALID_PROPERTY );
		}
		return $this->$method();
	}

	public function setOptions( array $options )
	{
		$methods = get_class_methods( $this );
		foreach( $options as $key => $value )
		{
			$method = 'set' . str_replace( " ", "", ucwords( str_replace( "_", " ", $key ) ) );
			if( in_array( $method, $methods ) )
			{
				$this->$method( $value );
			}
		}
		return $this;
	}

	public function toArray()
	{
		$vars = get_object_vars( $this );
		$vars = $this->filterToArray( $vars );
		return $vars;
	}
	
	protected function filterToArray( $vars )
	{
		unset( $vars[ '_mapper' ] );
		return $vars;
	}

	public function save()
	{
		if( $this->_mapper !== null )
		{
			$this->_mapper->save( $this );
		}
	}

	public function delete()
	{
		if( $this->_mapper !== null )
		{
			return $this->_mapper->delete( $this );
		}
    return false;
	}
}