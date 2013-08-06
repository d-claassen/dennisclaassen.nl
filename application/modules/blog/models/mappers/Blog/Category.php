<?php

class Blog_Model_Mapper_Blog_Category extends Application_Model_Mapper_Abstract
{
    public function getCategoryByBlog( $blogId )
    {
        $itemTable = new Blog_Model_DbTable_Blog_Post();
        $select = $this->getDbTable()->select()->setIntegrityCheck(false);
        $select->from( array( 'c' => $this->getDbTable()->info( 'name' ) ) )
            ->join( array( 'i' => $itemTable->info( 'name' ) ), 'c.id = i.category_id', '' )
            ->where( 'i.id = ?', $blogId );

        $data = $select->query()->fetchAll();

        $category = new Blog_Model_Blog_Category();
        $category->setOptions( $data[ 0 ] );

        return $category;

    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Blog_Model_Blog_Category();
            
            $entry->setOptions($row->toArray());
            $entries[] = $entry;
        }
        return $entries;
    }
}