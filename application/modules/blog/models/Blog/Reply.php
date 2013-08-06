<?php

class Blog_Model_Blog_Reply extends Application_Model_Abstract
{
  protected $id = '',
    $item_id = '',
    $user_id = '',
    $content = '',
    $created = '',

    $user = null,
    $item = null;

  public function reset()
  {
    $this->setId( '' );
    $this->setItemId( '' );
    $this->setUserid( '' );
    $this->setContent( '' );
    $this->setCreated( '' );

    $this->setUser( null );
    $this->setItem( null );
  }

  public function getId()
  {
    return $this->id;
  }
  public function setId( $id )
  {
    $this->id = $id;
    return $this;
  }

  public function getItemId()
  {
    return $this->item_id;
  }
  public function setItemId( $item_id )
  {
    $this->item_id = $item_id;
    return $this;
  }

  public function getUserId()
  {
    return $this->user_id;
  }
  public function setUserId( $user_id )
  {
    $this->user_id = $user_id;
    return $this;
  }

  public function getContent()
  {
    return $this->content;
  }
  public function setContent( $content )
  {
    $this->content = $content;
    return $this;
  }

  public function getCreated()
  {
    return $this->created;
  }
  public function setCreated( $created )
  {
    $this->created = $created;
    return $this;
  }

  public function loadUser()
  {
    $mapper = new Application_Model_Mapper_User();
    $user = $mapper->fetchById( $this->getUserId() );
    $this->setUser( array_shift( $user ) );
    return $this;
  }
  public function getUser()
  {
    if( is_null( $this->user ) )
    {
      $this->loadUser();
    }
    return $this->user;
  }
  public function setUser( $user )
  {
    $this->user = $user;
    return $this;
  }

  public function loadItem()
  {
    $mapper = new Blog_Model_Mapper_Blog_Item();
    $item = $mapper->fetchById( $this->getItemId() );
    $this->setItem( $item );
    return $this;
  }
  public function getItem()
  {
    if( is_null( $this->item ) )
    {
      $this->loadItem();
    }
    return $this->item;
  }
  public function setItem( $item )
  {
    $this->item = $item;
    return $this;
  }
}