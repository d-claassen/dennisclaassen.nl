<?php

class Application_Model_Mapper_Acl_Controller extends Application_Model_Mapper_Abstract
{
	public function getControllers()
	{
		$select = $this->getDbTable()->select();
		$select->from( 'acl_controllers' );
		 
		$data = $select->query()->fetchAll();
		$entries = array();
		foreach( $data as $row )
		{
			$entry = new Application_Model_Acl_Controller( $row );
			$entries[] = $entry;
		}
		return $entries;
	}
}