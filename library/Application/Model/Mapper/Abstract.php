<?php

abstract class Application_Model_Mapper_Abstract implements Application_Model_Mapper_Interface
{
	protected $_dbTable;

	public function setDbTable( $dbTable )
	{
		if ( is_string( $dbTable ) )
		{
			$dbTableClass = new $dbTable();
		}
		if ( !$dbTableClass instanceof Zend_Db_Table_Abstract )
		{
			throw new Application_Model_Mapper_Exception( 'Invalid database table [' . $dbTable . '] provided.', Application_Model_Mapper_Exception::INVALID_DATABASE_TABLE );
		}
		$this->_dbTable = $dbTableClass;
		return $this;
	}

	public function getDbTable()
	{
		if ( $this->_dbTable === null )
		{
			$this->setDbTable( str_replace( 'Model_Mapper', 'Model_DbTable', get_class( $this ) ) );
		}
		return $this->_dbTable;
	}

    public function __call( $name, $arguments )
    {
      if( strpos( $name, 'fetchBy' ) !== false )
      {
        if( strpos( $name, 'fetchBy' ) === 0 )
        {
            $field = ltrim( $name, 'fetchBy' );
            $field = '`' . $field . '` = ?';

            if( count( $arguments ) === 0 || is_null( $arguments[ 0 ] ) )
            {
                throw new Exception( 'Missing argument for method ' . __CLASS__ . '::' . $name );
            }
        }

        return call_user_func( array( $this, 'fetchBy' ), array( $field => $arguments[ 0 ] ) );
      }
    }

    public function fetchBy( $fields )
    {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable());

        foreach( $fields as $query => $value )
        {
            if( !is_numeric( $query ) )
            {
                $select->where( $query, $value );
            }
            else
            {
                $select->where( $value );
            }
        }

        $data = $select->query()->fetchAll();

        $entries   = array();
        $className = str_replace( 'Model_Mapper', 'Model', get_class( $this ) );
        foreach ($data as $row)
        {
            $entry = new $className($row);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetch($where, $order)
    {
    	$select = $this->getDbTable()->select();
    	$select->from($this->getDbTable())
    		->where($where)
    		->order($order);
    	
    	$data = $select->query()->fetchAll();

    	$entries   = array();
        foreach ($data as $row) {
            $entry = new Blog_Model_Blog($row);
            $entries[] = $entry;
        }
        return $entries;
    }

	public function save( Application_Model_Interface $model )
	{
		if( is_null( $model->{$model::IDENTIFIER_FIELD} ) || strlen( $model->{$model::IDENTIFIER_FIELD} ) === 0 || $model->{$model::IDENTIFIER_FIELD} === false )
		{
			$this->getDbTable()->insert( $model->toArray() );
		}
		else
		{
			$this->getDbTable()->update( $model->toArray(), $this->getWhereClause( $model ) );
		}
	}
	
	public function delete( Application_Model_Interface $model )
	{
		return $this->getDbTable()->delete( $this->getWhereClause( $model ) );
	}

	protected function getWhereClause( Application_Model_Interface $model )
	{
		$className = get_class( $model );
		if( $className::IDENTIFIER_FIELD !== null )
		{
			if( is_string( $className::IDENTIFIER_FIELD ) )
			{
				return array(
					'`' . $className::IDENTIFIER_FIELD . '` = ?' => $model->{$className::IDENTIFIER_FIELD}
				);
			}
			elseif( is_array( $class::IDENTIFIER_FIELD ) )
			{
				$r = array();
				foreach( $className::IDENTIFIER_FIELD as $idKey )
				{
					$r[ '`' . $idKey . '` = ?' ] = $model->$idKey;
				}
				return $r;
			}
		}
	}
}