<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initSession()
	{
		Zend_Session::start();
	}
	
	protected function _initRoutes()
	{
    $this->bootstrap('FrontController');  
    $front = $this->getResource('FrontController');  
    $router = $front->getRouter(); 

		$noWWWHostnameRoute = new Zend_Controller_Router_Route_Hostname(
			DOMAIN,
			array( 'module' => 'default', 'controller' => 'index', 'action' => 'index' )
		);
		
		$defaultHostnameRoute = new Zend_Controller_Router_Route_Hostname(
			'www.' . DOMAIN,
			array( 'module' => 'default', 'controller' => 'index', 'action' => 'index' )
		);
		
		$dispatcher = $front->getDispatcher();
		$request = $front->getRequest();
		$moduleRoutes = new Zend_Controller_Router_Route_Module( array(), $dispatcher, $request );

    $router->addRoute( 'defaultwww', $defaultHostnameRoute->chain( $moduleRoutes ) ); // www.DOMAIN/module/controller/action/*
		$router->addRoute( 'default', $noWWWHostnameRoute->chain( $moduleRoutes ) ); // DOMAIN/module/controller/action/*
	}

	protected function _initViewSettings()
	{
		$this->bootstrap( 'view' );
		$view = $this->getResource( 'view' );
		// doctype
		$view->doctype( 'HTML5' );
		// title
		$view->headTitle( 'Dennis Claassen.nl' )
			->setSeparator(' - ')
			->setDefaultAttachOrder( 'PREPEND' );
		// scripts
		$view->headScript()
			->appendFile( '/js/html5.js' )

      ->appendFile( "//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" )
      ->appendScript( 
        'window.jQuery || document.write(\'<script src="/js/jquery.min.js"><\/script>\')'
      )
//      ->appendFile( '/js/jquery.min.js' )
			->appendFile( '/js/jquery-ui-1.8.14.custom.min.js' )
      ->appendFile( '/js/jquery.confirm.js' )
      ->appendFile( '/js/bootstrap.min.js' )
			->appendScript( 
'jQuery(function($){
  $(".btn-confirm").confirm();
});'
			)
			->offsetSetScript( 100,
"  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28367061-1']);
  _gaq.push(['_setDomainName', 'dennisclaassen.nl']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();"
			);

		// links
		$view->headLink()
      // append our own stylesheet, so these rule overrule others
      ->appendStylesheet( '/css/style.min.css' );
		// default meta tags
		$view->headMeta()
			->setCharset( 'UTF-8' )
			->appendName( 'description', 'Alles over Dennis Claassen' )
			->appendName( 'keywords', 'Dennis Claassen, web, developer')
			->appendName( 'author', 'Dennis Claassen' )
			->appendName( 'viewport', 'width=device-width' ) // force mobile phones to use smaller viewports
			->appendHttpEquiv( 'Content-Type', 'text/html; charset=utf-8' );

		$view->addHelperPath( 'Application/View/Helper/', 'Application_View_Helper' )
      ->addHelperPath( 'TwitterBootstrap/View/Helper/', 'TwitterBootstrap_View_Helper' );
	}

	protected function _initModularLayout()
	{
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin( new Application_Plugin_Layout() );
	}

	protected function _initUser()
	{
		$session = new Zend_Session_Namespace( 'user' );

		if ( isset( $session->user ) )
		{
			$user = $session->user;
		}
		else
		{
			$user = new Application_Model_User();
			$session->user = $user;
		}

		Zend_Registry::set( 'user', $user );
	}

	protected function _initPlugins()
	{
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin( new Application_Plugin_Authentication() );
		$front->registerPlugin( new Application_Plugin_ErrorControllerSelector() );
	}
	
	protected function _initNavigation()
	{
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin( new Application_Plugin_Navigation() );
		$view = $this->getResource( 'view' );
		$view->navigation()
			->setAcl( Application_Model_Acl::getInstance() )
			->setRole( Zend_Registry::get( 'user' )->getRole() );
	}

}
