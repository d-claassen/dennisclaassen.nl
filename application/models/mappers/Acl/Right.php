<?php

class Application_Model_Mapper_Acl_Right extends Application_Model_Mapper_Abstract
{
	/**
	 * Overwrite getDbTable because we don't have a special database table for this model
	 */
	public function getDbTable()
	{
		if ( $this->_dbTable === null )
		{
			$this->setDbTable( 'Application_Model_DbTable_Acl' );
		}
		return $this->_dbTable;
	}
	
	/**
	 * Overwrite save function because this is a special model.
	 * All the properties of the model together make it a unique model
	 * 
	 * @param Application_Model_Interface $model The model to save
	 */
	public function save( Application_Model_Interface $model )
	{
		var_dump( $model->toArray() );
		
		$this->getDbTable()->insert( $model->toArray() );
	}
}