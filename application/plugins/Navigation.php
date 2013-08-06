<?php

class Application_Plugin_Navigation extends Zend_Controller_Plugin_Abstract
{

	public function routeShutdown(Zend_Controller_Request_Abstract $request)
	{
		// Get the view, we'll need to assign the navigation to it later
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
		if (null === $viewRenderer->view)
		{
			$viewRenderer->initView();
		}
		$view = $viewRenderer->view;

		// Create a new Navigation Object
		$container = new Application_Model_Navigation();
		$container->loadPages();

		// Assign the navigation to the view
		$view->navigation($container);
		
	}

}