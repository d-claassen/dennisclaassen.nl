<?php

class AboutController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		$this->_redirect( $this->view->url( array(
				'module' => 'default',
				'controller' => 'index',
				'action' => 'index',
			) ) );
	}

}