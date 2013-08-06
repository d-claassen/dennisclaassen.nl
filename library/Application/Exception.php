<?php

class Application_Exception extends Zend_Exception
{
  /*
	protected $_adapter;

	public function __construct( $msg = '', $code = 0, Exception $previous = null )
	{
		if( $this->initAdapter() )
		{
			$this->save( $msg, $code );
		}
		parent::__construct($msg, (int) $code, $previous);
	}

	private function initAdapter()
	{
		if( $this->_adapter === null )
		{
			$this->_adapter = Zend_Db_Table_Abstract::getDefaultAdapter();
			if( null === $this->_adapter )
			{
				throw new Zend_Exception( 'No database adapter present.' );
				return false;
			}
		}
		return true;
	}

	private function save( $msg = '', $code = 0 )
	{
		if( $this->_adapter !== null )
		{
			$this->_adapter->insert( 'exceptions', array(
            	'message' => $msg, 
            	'code' => $code,
            	'file' => $this->getFile(),
            	'line' => $this->getLine(),
            	'trace' => $this->getTraceAsString(),
            	'created_on' => new Zend_Db_Expr( 'NOW()' )
			) );

			return true;
		}
		return false;
	}
  */
}