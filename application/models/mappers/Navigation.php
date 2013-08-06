<?php

class Application_Model_Mapper_Navigation extends Application_Model_Mapper_Abstract
{
	public function loadPages()
	{
		$select = $this->getDbTable()->select()->setIntegrityCheck( false );
		$select->from( 'navigation' );

		$data = $select->query()->fetchAll();
		$entries = array();
		foreach( $data as $row )
    {
			$entry = new Application_Model_Navigation_Page( $row );
			$entries[] = $entry;
		}
		return $entries;
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
    foreach ($data as $row)
    {
      $entry = new Application_Model_Navigation_Page( $row );
      $entries[] = $entry;
    }
    return $entries;
  }

  public function save( Application_Model_Interface $model )
  {
    if( is_null( $model->{$model::IDENTIFIER_FIELD} ) || strlen( $model->{$model::IDENTIFIER_FIELD} ) === 0 || $model->{$model::IDENTIFIER_FIELD} === false )
    {
      return $this->getDbTable()->insert( $model->toSaveArray() );
    }
    else
    {
      return $this->getDbTable()->update( $model->toSaveArray(), $this->getWhereClause( $model ) );
    }
  }

  public function delete( Application_Model_Interface $model )
  {
	  return $this->getDbTable()->delete( $this->getWhereClause( $model ) );
  }
}