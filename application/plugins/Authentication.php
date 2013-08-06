<?php

class Application_Plugin_Authentication extends Zend_Controller_Plugin_Abstract
{

	public function routeShutdown(Zend_Controller_Request_Abstract $request)
	{
		$user = Zend_Registry::get('user');

		$acl = Application_Model_Acl::getInstance();
		$acl->load();
		if ( count( $acl->getRoles() ) === 0 )
		{
			// $this->getResponse()->appendBody( 'There are no acl roles defined!' );
			return;
		}

		if ( count( $acl->getResources() ) === 0 )
		{
			// $this->getResponse()->appendBody( 'There are no acl resources defined!' );
			return;
		}

		if ( !$acl->has( $request->getModuleName() . ':' . $request->getControllerName() ) )
		{
			// $this->getResponse()->appendBody( 'The page does not exist.' );
			return;
		}
		if ( !$acl->isAllowed( $user->getRole(), $request->getModuleName() . ':' . $request->getControllerName(), $request->getActionName() ) )
		{
			// $this->getResponse()->appendBody( 'You are not allowed to view this page.' );
		}
	}


}