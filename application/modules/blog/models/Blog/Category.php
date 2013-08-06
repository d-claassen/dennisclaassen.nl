<?php

class Blog_Model_Blog_Category extends Application_Model_Abstract
{
  protected $id = '',
    $name = '',
    $slug = '',
    $description = '';

  public function reset()
  {
    $this->setId( null );
    $this->setName( null );
    $this->setSlug( null );
    $this->setDescription( null );
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
    
  public function getDescription()
  {
    return $this->description;
  } 
  public function setDescription( $description )
  {
    $this->description = $description;
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
        'controller' => 'category',
        'slug' => $this->getSlug()
      ), 'blogdefaultviewslug' );
  }
}