<?php

class Application_Model_Mapper_Acl_Role extends Application_Model_Mapper_Abstract
{
	public function getRoles()
	{
		$select = $this->getDbTable()->select();
		$select->from( 'acl_roles' );
		 
		$data = $select->query()->fetchAll();
		$entries = array();
		foreach( $data as $row )
		{
			$entry = new Application_Model_Acl_Role( $row );
			$entries[] = $entry;
		}
		return $entries;
	}
}