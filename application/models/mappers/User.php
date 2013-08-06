<?php

class Application_Model_Mapper_User extends Application_Model_Mapper_Abstract
{
	public function getUserBy($field, $value)
	{
		$select = $this->getDbTable()->select()->setIntegrityCheck( false );
		$select->from( array( 'u' => 'users' ) )
			->join( array( 'ar' => 'acl_roles' ), 'ar.id = u.role_id', array( 'role' => 'name' ) )
			->where( $field . ' = ?', $value );
		 
		$data = $select->query()->fetch();
		$entry = new Application_Model_User( $data );
		return $entry;
	}
}