<?php

class Admin_AclController extends Zend_Controller_Action
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
		$aclMapper = new Application_Model_Mapper_Acl();
		$rights = $aclMapper->getRights();

		$rights = Zend_Paginator::factory( $rights );
		$rights->setCurrentPageNumber( $this->_getParam( 'page' ) );

		$this->view->rights = $rights;
	}

	public function addAction()
	{
		$roleMapper = new Application_Model_Mapper_Acl_Role();
		$moduleMapper = new Application_Model_Mapper_Acl_Module();
		$controllerMapper = new Application_Model_Mapper_Acl_Controller();
		$actionMapper = new Application_Model_Mapper_Acl_Action();

		// prepare the form with the correct data
		$roles = $roleMapper->getRoles();
		$form = new Admin_Form_Acl_Rights();
		$form->getElement( 'role_id' )
			->addMultiOptions( array( '' => '' ) )
			->addMultiOptions( $this->getArrayStructured( $roles ) );
		$form->getElement( 'module_id' )
			->addMultiOptions( array( '' => '' ) )
			->addMultiOptions( $this->getArrayStructured( $moduleMapper->getModules() ) );
		$form->getElement( 'controller_id' )
			->addMultiOptions( array( '' => '' ) )
			->addMultiOptions( $this->getArrayStructured( $controllerMapper->getControllers() ) );
		$form->getElement( 'action_id' )
			->addMultiOptions( array( '' => '' ) )
			->addMultiOptions( $this->getArrayStructured( $actionMapper->getActions() ) );
		$form->getElement( 'type' )
			->addMultiOptions( array( '' => '' ) )
			->addMultiOptions( array(
				Application_Model_Acl_Right::ALLOW => Application_Model_Acl_Right::ALLOW,
				Application_Model_Acl_Right::DENY => Application_Model_Acl_Right::DENY
			) );
		
		if ( $this->getRequest()->isPost() )
		{
			if ( $this->getRequest()->getPost( 'rights' ) && $form->isValid( $this->getRequest()->getPost() ) )
			{
				$newRight = new Application_Model_Acl_Right( $form->getValues( 'rights' ) );
				$newRight->save();
				$form->reset();
			}
		}
		
		$this->view->form = $form;
	}
	
	public function addModuleAction()
	{
		$form = new Admin_Form_Acl_Module_Add();
		$form->setAction( $this->view->url() );
		
		if ( $this->getRequest()->isPost() )
		{
			if ( $this->getRequest()->getPost( 'modules' ) && $form->isValid( $this->getRequest()->getPost() ) )
			{
				$newModule = new Application_Model_Acl_Module( $form->getValues( 'modules' ) );
				$newModule->save();
				$form->reset();
			}
		}
		
		$this->view->form = $form;
		if( !$this->getRequest()->isXmlHttpRequest() )
		{
			$this->render( 'add' );
			return;
		}
		$this->_helper->layout->disableLayout();
	}
	
	public function addControllerAction()
	{
		$form = new Admin_Form_Acl_Controller_Add();
		$form->setAction( $this->view->url() );
		
		if ( $this->getRequest()->isPost() )
		{
			if ( $this->getRequest()->getPost( 'controllers' ) && $form->isValid( $this->getRequest()->getPost() ) )
			{
				$newController = new Application_Model_Acl_Controller( $form->getValues( 'controllers' ) );
				$newController->save();
				$form->reset();
			}
		}
		
		$this->view->form = $form;
		if( !$this->getRequest()->isXmlHttpRequest() )
		{
			$this->render( 'add' );
			return;
		}
		$this->_helper->layout->disableLayout();
	}
	
	public function addActionAction()
	{
		$form = new Admin_Form_Acl_Action_Add();
		$form->setAction( $this->view->url() );
		
		if ( $this->getRequest()->isPost() )
		{
			if ( $this->getRequest()->getPost( 'actions' ) && $form->isValid( $this->getRequest()->getPost() ) )
			{
				$newAction = new Application_Model_Acl_Action( $form->getValues( 'actions' ) );
				try
				{
					$newAction->save();
				}
				catch( Exception $e )
				{
					var_dump( $e );
				}
				
				$form->reset();
			}
		}
		
		$this->view->form = $form;
		if( !$this->getRequest()->isXmlHttpRequest() )
		{
			$this->render( 'add' );
			return;
		}
		$this->_helper->layout->disableLayout();
	}
	
	public function addRoleAction()
	{
		$roleMapper = new Application_Model_Mapper_Acl_Role();
		$roles = $roleMapper->getRoles();
		
		// prepare the form with the correct data
		$form = new Admin_Form_Acl_Role_Add();
		$form->setAction( $this->view->url() );
		$form->getElement( 'parent' )
			->addMultiOptions( array( '' => 'Niemand' ) )
			->addMultiOptions( $this->getArrayStructured( $roles, 'name' ) );
			
		if ( $this->getRequest()->isPost() )
		{
			if ( $this->getRequest()->getPost( 'roles' ) && $form->isValid( $this->getRequest()->getPost() ) )
			{
				$newRole = new Application_Model_Acl_Role( $form->getValues( 'roles' ) );
				$newRole->save();
				$form->reset();
			}
		}
		
		$this->view->form = $form;
		
		if( !$this->getRequest()->isXmlHttpRequest() )
		{
			$this->render( 'add' );
			return;
		}
		$this->_helper->layout->disableLayout();
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