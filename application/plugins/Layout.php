<?php

class Application_Plugin_Layout extends Zend_Controller_Plugin_Abstract
{

	public function routeShutdown(Zend_Controller_Request_Abstract $request)
	{
		$layout = Zend_Layout::getMvcInstance();
		$layout->setLayoutPath(APPLICATION_PATH . '/modules/' . $request->getModuleName() . '/layouts/scripts');
	}

}
