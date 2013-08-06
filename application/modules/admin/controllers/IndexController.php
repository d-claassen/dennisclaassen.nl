<?php

class Admin_IndexController extends Zend_Controller_Action
{

	public function init()
	{
		$user = Zend_Registry::get('user');

		if ( !$user->isLoggedIn() )
		{
			$this->_redirect( $this->view->url( array(
        		'controller' => 'user',
        		'action' => 'login'
        	) ) );
		}
	}

	public function indexAction()
	{
	}

}