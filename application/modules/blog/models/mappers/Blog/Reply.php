<?php

class Blog_Model_Mapper_Blog_Reply extends Application_Model_Mapper_Abstract
{
  public function getRepliesByBlog( $blog_id )
  {
    $dbTable = new Blog_Model_DbTable_Blog_Item();

    $select = $this->getDbTable()->select()->setIntegrityCheck( false );
    $select->from( array( 'r' => $this->getDbTable()->info( 'name' ) ) )
      ->join( array( 'i' => $dbTable->info( 'name' ) ), 'r.item_id = i.id', array() )
      ->where( 'i.id = ?', $blog_id );

    $data = $select->query()->fetchAll();

    $entries = array();
    foreach( $data as $row )
    {
      $entry = new Blog_Model_Blog_Reply( $row );
      $entries[] = $entry;
    }
    return $entries;
  }
}