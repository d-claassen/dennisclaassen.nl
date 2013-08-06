<?php

class Blog_Model_Blog_Item extends Application_Model_Abstract
{
  const STATUS_APPROVED = 'APPROVED',
    STATUS_DRAFT = 'DRAFT';

	protected $id = null,
    $title = '',
    $author_id = null,
    $description = '',
    $content = '',
		$created_on = '',
    $slug = '',
    $status = self::STATUS_DRAFT,

    $replies = null,
    $author = null,
		$category = null,
		$labels = null;
		
	public function reset()
	{
		$this->setId( null );
		$this->setTitle( null );
		$this->setAuthorId( null );
		$this->setContent( null );
		$this->setCreatedOn( null );
		$this->setAuthor( null );
    $this->setStatus( null );
		$this->setCategories( array() );
		$this->setLabels( array() );
	}

  public function getId()
  {
  	return $this->id;
  }
  
  public function setId($id)
  {
  	$this->id = $id;
  	return $this;
  }
  
  public function getTitle()
  {
  	return $this->title;
  }
  
  public function setTitle($title)
  {
  	$this->title = $title;
  	return $this;
  }

  public function getSlug()
  {
    $slug = $this->title;
    
    $slug = str_replace( " ", "-", $slug );
    $slug = preg_replace( '/([^\x2D\x30-\x39\x41-\x5A\x61-\x7A])/i', '', $slug );
    $slug = preg_replace( "/-{2,}/", "-", $slug );
    $slug = trim( $slug, "-" );
    $slug = strtolower( $slug );

  	return $slug;
  }
  public function setSlug( $slug )
  {
      $this->slug = $slug;
      return $this;
  }
  
  public function getAuthorId()
  {
  	return $this->author_id;
  }
  
  public function setAuthorId($author_id)
  {
  	$this->author_id = $author_id;

  	$mapper = new Application_Model_Mapper_User();
		$author = $mapper->getUserBy('u.id', $author_id);
		$this->setAuthor($author);

  	return $this;
  }

  public function getAuthor()
  {
  	return $this->author;
  }
    
  public function setAuthor($author)
  {
  	$this->author = $author;
  	return $this;
  }

  public function getDescription()
  {
    return $this->description;
  }
  
  public function setDescription($description)
  {
    $this->description = $description;
    return $this;
  }

  public function getContent()
  {
    return $this->content;
  }
  
  public function setContent($content)
  {
    $this->content = $content;
    return $this;
  }
  
  public function getCreatedOn()
  {
  	return $this->created_on;
  }
  
  public function setCreatedOn( $created_on )
  {
  	$this->created_on = $created_on;
  	return $this;
  }

  public function getStatus()
  {
    return $this->status;
  }

  public function setStatus( $status )
  {
    if( !in_array( $status, array( self::STATUS_APPROVED, self::STATUS_DRAFT ) ) )
    {
      throw new Application_Exception( __CLASS__ . '::status can not be set to ' . $status );
    }
    $this->status = $status;
    return $this;
  }

  public function loadCategory()
  {
    $mapper = new Blog_Model_Mapper_Blog_Category();
    $category = $mapper->getCategoryByBlog( $this->getId() );
    $this->setCategory( $category );
    return $this;  
  }
    
  public function getCategory()
  {
    if( is_null( $this->category ) )
    {
      $this->loadCategory();
    }
    return $this->category;
  }
  
  public function setCategory($category)
  {
    $this->category = $category;
    return $this;
  }
  
  public function loadLabels()
  {
  	$mapper = new Blog_Model_Mapper_Blog_Label();
  	$labels = $mapper->getLabelsByBlog( $this->getId() );
  	$this->setLabels( $labels );
  	return $this;
  }
  public function getLabels()
  {
    if( is_null( $this->labels ) )
    {
      $this->loadLabels();
    }
  	return $this->labels;
  }
  public function setLabels($labels)
  {
  	$this->labels = $labels;
  	return $this;
  }

  public function loadReplies()
  {
    $mapper = new Blog_Model_Mapper_Blog_Reply();
    $replies = $mapper->fetchByItem_Id( $this->getId() );
    $this->setReplies( $replies );
    return $this;
  }
  public function getReplies()
  {
    if( is_null( $this->replies ) )
    {
      $this->loadReplies();
    }
    return $this->replies;
  }
  public function setReplies( $replies )
  {
    $this->replies = $replies;
    return $this;
  }

  public function getUrl()
  {
    // need a view for the url helper function
    $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper( 'viewRenderer' );
    if ( $viewRenderer->view === null )
    {
      $viewRenderer->initView();
    }
    $view = $viewRenderer->view;

    return $view->url( array( 
      'module' => 'blog', 
      'controller' => 'item', 
      'action' => 'view', 
      'id' => $this->getId(), 
      'slug' => $this->getSlug()
    ), 'blogitem' );
  }

  public function save()
  {
    $s = 'abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ0123456789-';
    $r = '';
    for( $i = 0, $j = strlen( $s ); $i < $j; $i++, $r .= $s[ rand( 0, $j ) ] );
    $this->setSlug( $r );
    parent::save();
  }

  protected function filterToArray( $vars )
  {
    $vars = parent::filterToArray( $vars );
    unset( $vars[ 'replies' ] );
    unset( $vars[ 'author' ] );
    unset( $vars[ 'category' ] );
    unset( $vars[ 'labels' ] );
    return $vars;
  }
}