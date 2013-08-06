<?php

class Blog_Model_Mapper_Blog_Item extends Application_Model_Mapper_Abstract
{   
    public function __call( $name, $arguments )
    {
        if( strpos( $name, 'fetchBy' ) === 0 )
        {
            $field = ltrim( $name, 'fetchBy' );
            $field .= ' = ?';

            if( count( $arguments ) === 0 || is_null( $arguments[ 0 ] ) )
            {
                throw new Exception( 'Missing argument for method ' . __CLASS__ . '::' . $name );
            }
        }

        return call_user_func( array( $this, 'fetchBy' ), array( $field => $arguments[ 0 ] ) );
    }

    public function fetchBy( $fields )
    {
        $select = $this->getDbTable()->select();
        $select->from( $this->getDbTable() );

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
            $entry = new Blog_Model_Blog_Item($row);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetch($where, $order)
    {
    	$select = $this->getDbTable()->select();
    	$select->from($this->getDbTable())
    		->where($where)
    		->order($order);
    	
    	$data = $select->query()->fetchAll();

    	$entries   = array();
        foreach ($data as $row) {
            $entry = new Blog_Model_Blog_Item($row);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Blog_Model_Blog_Item();
            
            $entry->setOptions($row->toArray());
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function getCategoriesByBlog($id)
    {
    	$select = $this->getDbTable()->select()->setIntegrityCheck(false);
    	$select->from(array('b' => $this->getDbTable()->info('name')))
    		->join(array('bc' => 'blog_category'), 'blog_id = b.id')
    		->join(array('c' => 'category'), 'category_id = c.id', array('cid' => 'id', 'cname' => 'name'))
    		->where('b.id = ?', $id);
    	
    	$data = $select->query()->fetchAll();

    	$entries   = array();
        foreach ($data as $row) {
            $entry = new Blog_Model_Blog_Category();
            $entry->setId($row['cid'])
            	->setName($row['cname']);
            $entries[] = $entry;
        }
        return $entries;
    }

    
    public function getBlogsByLabel( $label_id )
    {
    	
    	$select = $this->getDbTable()->select()->setIntegrityCheck( false );
    	$select->from( array( 'b' => $this->getDbTable()->info( 'name' ) ) )
    		->join( array( 'bl' => 'blog_item_label' ), 'bl.blog_id = b.id', array() )
    		->where( 'bl.label_id = ?', $label_id );

    	$data = $select->query()->fetchAll();

    	$entries = array();
        foreach( $data as $row )
        {
            $entry = new Blog_Model_Blog_Item( $row );
            $entries[] = $entry;
        }
        return $entries;
    }
}