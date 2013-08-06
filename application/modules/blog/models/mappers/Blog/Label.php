<?php

class Blog_Model_Mapper_Blog_Label extends Application_Model_Mapper_Abstract
{    
    public function fetch($where, $order)
    {
    	$select = $this->getDbTable()->select();
    	$select->from( $this->getDbTable() )
    		->where( $where )
    		->order( $order );
    	
    	$data = $select->query()->fetchAll();

    	$entries   = array();
        foreach( $data as $row )
        {
            $entry = new Blog_Model_Blog_Label( $row );
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach( $resultSet as $row )
        {
            $entry = new Blog_Model_Blog_Label( $row->toArray() );
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function getLabelsByBlog( $blog_id )
    {
    	$dbTable = new Blog_Model_DbTable_Blog_PostLabel();

    	$select = $this->getDbTable()->select()->setIntegrityCheck( false );
    	$select->from( array( 'l' => $this->getDbTable()->info( 'name' ) ) )
    		->join( array( 'bl' => $dbTable->info( 'name' ) ), 'bl.label_id = l.id', array() )
    		->where( 'bl.blog_id = ?', $blog_id );

    	$data = $select->query()->fetchAll();

    	$entries = array();
        foreach( $data as $row )
        {
            $entry = new Blog_Model_Blog_Label( $row );
            $entries[] = $entry;
        }
        return $entries;
    }
}