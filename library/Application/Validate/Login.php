<?php

class Application_Validate_Login extends Zend_Validate_Abstract
{
  protected $_table = '';

  protected $_identity = '';

  protected $_password = '';

  protected $_hash = '';

  protected $_identityInContext = '';

  protected $_adapter = null;

  const INCORRECT_DATA = 'incorrectData';

  protected $_messageTemplates = array(
    self::INCORRECT_DATA => 'The given credentials are incorrect'
  );

  public function __construct( $options )
  {
    if( array_key_exists( 'table', $options ) )
    {
      $this->_table = $options[ 'table' ];
    }
    if( array_key_exists( 'identity', $options ) )
    {
      $this->_identity = $options[ 'identity' ];
    }
    if( array_key_exists( 'password', $options ) )
    {
      $this->_password = $options[ 'password' ];
    }
    if( array_key_exists( 'hash', $options ) )
    {
      $this->_hash = $options[ 'hash' ];
    }
    if( array_key_exists( 'identityField', $options ) )
    {
      $this->_identityInContext = $options[ 'identityField' ];
    }
    if( array_key_exists( 'db', $options ) )
    {
      $this->_adapter = $options[ 'db' ];
    }
  }

  public function isValid( $value, $context = null )
  {
    $value = (string) $value;
    $this->_setValue( $value );

    $adapter = new Zend_Auth_Adapter_DbTable(
      null,
      $this->_table,
      $this->_identity,
      $this->_password,
      $this->_hash
    );

    $adapter->setIdentity( $context[ $this->_identityInContext ] );
    $adapter->setCredential( $value );
     
    $auth = Zend_Auth::getInstance();
    $result = $auth->authenticate( $adapter );

    if( !$result->isValid() )
    {
      $this->_error( self::INCORRECT_DATA );
      return false;
    }

    return true;
  }


  /**
   * Returns the set adapter
   *
   * @return Zend_Db_Adapter
   */
  public function getAdapter()
  {
    /**
     * Check for an adapter being defined. if not, fetch the default adapter.
     */
    if ($this->_adapter === null) {
      $this->_adapter = Zend_Db_Table_Abstract::getDefaultAdapter();
      if (null === $this->_adapter) {
        require_once 'Zend/Validate/Exception.php';
        throw new Zend_Validate_Exception('No database adapter present');
      }
    }
    return $this->_adapter;
  }

  /**
   * Sets a new database adapter
   *
   * @param  Zend_Db_Adapter_Abstract $adapter
   * @return Zend_Validate_Db_Abstract
   */
  public function setAdapter($adapter)
  {
    if (!($adapter instanceof Zend_Db_Adapter_Abstract)) {
      require_once 'Zend/Validate/Exception.php';
      throw new Zend_Validate_Exception('Adapter option must be a database adapter!');
    }

    $this->_adapter = $adapter;
    return $this;
  }
}