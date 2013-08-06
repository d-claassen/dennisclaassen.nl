<?php

class Application_Model_Mapper_Acl_Module extends Application_Model_Mapper_Abstract
{
	public function getModules()
	{
		$select = $this->getDbTable()->select();
		$select->from( 'acl_modules' );
		 
		$data = $select->query()->fetchAll();
		$entries = array();
		foreach( $data as $row )
		{
			$entry = new Application_Model_Acl_Module( $row );
			$entries[] = $entry;
		}
		return $entries;
	}
}