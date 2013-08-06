<?php

class Admin_ErrorController extends Zend_Controller_Action
{
	protected $_navPage;
	
	public function init()
	{
    /*
		// We add this page to the navigation, so it shows up in the breadcrumbs
		$params = array(
			'module' => $this->getRequest()->getModuleName(),
			'controller' => $this->getRequest()->getControllerName(),
			'action' => $this->getRequest()->getActionName(),
			'active' => true,
			'visible' => false
		);
    $this->_navPage = new Zend_Navigation_Page_Mvc( $params );
      
    $root = array_shift( $this->view->navigation()->getContainer()->getPages() );
    $root->addPage( $this->_navPage );
    */
	}
	
	public function errorAction()
	{
		$errors = $this->_getParam('error_handler');

		switch ($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				// 404 error -- controller or action not found
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->message = 'Page not found';
				break;
			default:
				// application error
				$this->getResponse()->setHttpResponseCode(500);
				$this->view->message = 'Application error';
				break;
		}

		// Set the label for the navigation page to the error code
		// $this->_navPage->setLabel( (string)$this->getResponse()->getHttpResponseCode() );
		
		$this->view->exception = $errors->exception;
		$this->view->request   = $errors->request;
	}

}