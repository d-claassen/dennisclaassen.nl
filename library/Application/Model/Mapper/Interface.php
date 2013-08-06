<?php

interface Application_Model_Mapper_Interface
{
	public function setDbTable( $dbTable );
	public function getDbTable();

	// The save function can also update a model in the database
	public function save( Application_Model_Interface $model );
	public function delete( Application_Model_Interface $model );
}