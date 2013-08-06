<?php

class Application_Model_Mapper_Acl_Action extends Application_Model_Mapper_Abstract
{
	public function getActions()
	{
		$select = $this->getDbTable()->select();
		$select->from( 'acl_actions' );
		 
		$data = $select->query()->fetchAll();
		$entries = array();
		foreach( $data as $row )
		{
			$entry = new Application_Model_Acl_Action( $row );
			$entries[] = $entry;
		}
		return $entries;
	}
}