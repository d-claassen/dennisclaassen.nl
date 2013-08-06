<?php

class Blog_Model_Blog_Label extends Application_Model_Abstract
{
	protected $id = 0,
		$name,
		$blogs = array();

  public function __toString()
  {
    return "<a href='" . $this->getUrl() . "' class='label label-info'>" . $this->getName() . "</a>";
  }

	public function reset()
	{
		$this->setId( null );
		$this->setName( null );
		$this->setBlogs( array() );
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
  
  public function getName()
  {
  	return $this->name;
  }
  
  public function setName( $name )
  {
  	$this->name = $name;
  	return $this;
  }
  
  public function getSlug()
  {
  	return $this->slug;
  }
  
  public function setSlug( $slug )
  {
    $this->slug = $slug;
    return $this;
  }
  
  public function getBlogs()
  {
  	return $this->blogs;
  }
  
  public function setBlogs( $blogs )
  {
  	$this->blogs = $blogs;
  	return $this;
  }
  
  public function loadBlogs()
  {
  	$mapper = new Blog_Model_Mapper_Blog_Post();
  	$blogs = $mapper->getBlogsByLabel( $this->getId() );
  	$this->setBlogs( $blogs );
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
        'controller' => 'label',
        'slug' => $this->getSlug()
      ), 'blogdefaultviewslug' );
  }
  
  public static function getCloud()
  {
    $mapper = new Blog_Model_Mapper_Blog_Label();
    $labels = $mapper->fetchAll();
    
    $list = new Zend_Tag_ItemList();
    foreach( $labels as $label )
    {
      $label->loadBlogs();
      $list[] = new Zend_Tag_Item( array(
        'title' => $label->getName(),
        'weight' => count( $label->getBlogs() ),
        'params' => array(
          'url' => $label->getUrl()
        )
      ) );
    }
    
    $cloud = new Zend_Tag_Cloud();
    $cloud->setItemList( $list );
    
    return $cloud;
  }
}