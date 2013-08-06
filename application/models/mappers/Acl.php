<?php

class Application_Model_Mapper_Acl
{
	protected $_dbTable;

	public function setDbTable($dbTable)
	{
		if (is_string($dbTable))
		{
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract)
		{
			throw new Exception('Invalid table data gateway provided');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}

	public function getDbTable()
	{
		if (null === $this->_dbTable)
		{
			$this->setDbTable('Application_Model_DbTable_Acl');
		}
		return $this->_dbTable;
	}

	/**
	 * Retrieves the rights from the database as required by the ACL model
	 * Query it generates: 
SELECT name AS role, module, controller, action, type
FROM `acl` A
JOIN `acl_role` AR ON A.role_id = AR.id
JOIN `acl_module` AM ON A.module_id = AM.id
JOIN `acl_controller` AC ON A.controller_id = AC.id
JOIN `acl_action` AA ON A.action_id = AA.id
	 * 
	 */
	public function getRights()
	{
		$select = $this->getDbTable()->select()->setIntegrityCheck(false);
		$select->from( array( 'A' => 'acl' ), 'type' )
			->join( array( 'AR' => 'acl_roles' ), 'AR.id = A.role_id', array( 'role' => 'name' ) )
			->join( array( 'AM' => 'acl_modules' ), 'AM.id = A.module_id', 'module' )
			->join( array( 'AC' => 'acl_controllers' ), 'AC.id = A.controller_id', 'controller' )
			->join( array( 'AA' => 'acl_actions' ), 'AA.id = A.action_id', 'action' );

		$data = $select->query()->fetchAll();
		$entries = array();
		/** TODO $data == $entries?? */
		foreach ($data as $row) {
			$entry = $row;
			$entries[] = $entry;
		}
		return $entries;
	}
}