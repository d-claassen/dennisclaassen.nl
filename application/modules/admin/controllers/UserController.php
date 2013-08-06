<?php

class Admin_UserController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function loginAction()
	{
		$user = Zend_Registry::get( 'user' );

		if ( $user->isLoggedIn() )
		{
			$this->_redirect($this->view->url(array(
        			'controller' => 'index',
        			'action' => 'index'
        		)));
		}

		$form = new Admin_Form_Auth_Login();

		if ( $this->getRequest()->isPost() )
		{
			if( $form->isValid( $this->getRequest()->getPost() ) )
			{
    		$user->loadUserByUsername( $form->getValue( 'username' ) );

    		$this->_redirect( $this->view->url( array(
    			'action' => 'index',
    			'controller' => 'index'
    		) ) );
  		}
		}

		$this->view->form = $form;
	}

	public function logoutAction()
	{
		$user = Zend_Registry::get('user');
		 
		if ( $user->isLoggedIn() )
		{
			$user->setRole(Application_Model_User::DEFAULT_ROLE);
		}
		 
		$this->_redirect( $this->view->url( array(
    			'action' => 'index',
    			'controller' => 'index'
    			) ) );
	}

}