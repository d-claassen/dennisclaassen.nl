<?php

class Admin_NavigationController extends Zend_Controller_Action
{

	public function init()
	{
		$user = Zend_Registry::get('user');

		if ( !$user->isLoggedIn() )
		{
			$this->_redirect($this->view->url(array(
  			'controller' => 'user',
  			'action' => 'login'
  		)));
		}
	}

	public function indexAction()
	{
		$navigationMapper = new Application_Model_Mapper_Navigation();
		
		$form = new Admin_Form_Navigation_Page();
		$form->setAction( $this->view->url( array( 'action' => 'add' ) ) );
		$form->getElement( 'parent_id' )
			->addMultiOptions(
				$this->getArrayStructured( $navigationMapper->loadPages() )
			);
		
		$this->view->saved = $this->_getParam( 'saved' ) !== null;
		$this->view->form = $form;
		$this->view->headScript()->appendFile('/js/navigation.js');
	}
	
	public function addAction()
	{
		$navigationMapper = new Application_Model_Mapper_Navigation();
		$form = new Admin_Form_Navigation_Page();
		
		$form->getElement( 'parent_id' )
			->addMultiOptions(
				$this->getArrayStructured( $navigationMapper->loadPages() )
			);
		
		if( $this->getRequest()->isPost() && $form->isValid( $this->getRequest()->getPost() ) )
		{
			$newPage = new Application_Model_Navigation_Page( $form->getValues() );
			$newPage->save();
			
      if( $this->view->page )
      {
        $this->_helper->FlashMessenger( array( 'success' => 'Pagina "' . $newPage->getLabel() . '" is bijgewerkt.' ) );
      }
      else
      {
        $this->_helper->FlashMessenger( array( 'success' => 'Pagina "' . $newPage->getLabel() . '" is aangemaakt.' ) );
      }
			$this->_redirect( $this->view->url( array( 
          'module' => 'admin',
          'controller' => 'navigation',
          'action' => 'index'
        ), 'default', true ) );
		}

		if( $this->view->page )
		{
			$form->populate( $this->view->page->toArray() )
				->setLegend( 'Pagina wijzigen' );
		}
		
		$this->view->form = $form;
	}

  public function editAction()
  {
    if( is_null( $this->_getParam( 'id' ) ) )
    {
      $this->_redirect( $this->view->url( array( 'action' => 'add' ) ) );
    }

		$navigationMapper = new Application_Model_Mapper_Navigation();
    $pages = $navigationMapper->fetchById( $this->_getParam( 'id' ) );
    $Page = $pages[ 0 ];

    $this->view->page = $Page;
    $this->_forward( 'add' );
  }

  public function deleteAction()
  {
    if( is_null( $this->_getParam( 'id' ) ) )
    {
      $this->_redirect( $this->view->url( array( 'action' => 'index' ) ) );
    }

		$navigationMapper = new Application_Model_Mapper_Navigation();
		
    $pages = $navigationMapper->fetchById( $this->_getParam( 'id' ) );
    $Page = $pages[ 0 ];

    $pageName = $Page->getLabel();
    if( $Page->delete() )
    {
      $this->_helper->FlashMessenger( array( 'success' => 'Pagina "' . $pageName . '" is verwijderd.' ) );
    }
    else
    {
      $this->_helper->FlashMessenger( array( 'error' => 'Pagina "' . $pageName . '" is niet verwijderd.' ) );
    }

    $this->_redirect( $this->view->url( array( 
      'module' => 'admin',
      'controller' => 'navigation',
      'action' => 'index',
      ), 'default', true ) );
  }
    
  protected function getArrayStructured( $array, $key = 'id' )
  {
  	$newArray = array();
  	foreach( $array as $item )
  	{
  		$newArray[ $item->{$key} ] = $item;
  	}
  	return $newArray;
  }
}