<?php

class Blog_Bootstrap extends Zend_Application_Module_Bootstrap
{
	protected function _initRoutes()
	{
		$front = Zend_Controller_Front::getInstance();
		$router = $front->getRouter();
	
		$blogHostnameRoute = new Zend_Controller_Router_Route_Hostname(
			'blog.' . DOMAIN,
			array( 'module' => 'blog', 'controller' => 'index', 'action' => 'index' )
		);
		
		$blogRoutes = new Zend_Controller_Router_Route(
			':controller/:action/*',
			array(
				'module' => 'blog',
				'controller' => 'index',
				'action' => 'index'
			)
		);

		$blogViewRoute = new Zend_Controller_Router_Route_Regex(
			'([A-z]+)/(\d+)-(.+)',
			array( 'action' => 'view' ),
			array( 'controller' => 1, 'id' => 2, 'slug' => 3 ),
			'%s/%d-%s'
		);

		$blogViewSlugOnlyRoute = new Zend_Controller_Router_Route_Regex(
			'([A-z]+)/(.+)',
			array( 'action' => 'view' ),
			array( 'controller' => 1, 'slug' => 2 ),
			'%s/%s'
		);
		
		$blogItemRoute = new Zend_Controller_Router_Route_Regex(
			'(\d+)-(.+)',
			array( 'controller' => 'item', 'action' => 'view'),
			array('id' => 1, 'slug' => 2),
			'%d-%s'
		);
		
		$router->addRoute( 'bloghost', $blogHostnameRoute ); // blog.DOMAIN
		$router->addRoute( 'blogdefault', $blogHostnameRoute->chain( $blogRoutes ) ); // blog.DOMAIN/controller/action/*
		$router->addRoute( 'blogdefaultview', $blogHostnameRoute->chain( $blogViewRoute ) ); // blog.DOMAIN/controller/123-some-titel
		$router->addRoute( 'blogdefaultviewslug', $blogHostnameRoute->chain( $blogViewSlugOnlyRoute ) ); // blog.DOMAIN/controller/some-titel
		$router->addRoute( 'blogitem', $blogHostnameRoute->chain( $blogItemRoute ) ); // blog.DOMAIN/123-some-blog-titel
	}
	
	protected function _initAdminRoutes()
	{
		$front = Zend_Controller_Front::getInstance();
		$router = $front->getRouter();
		
		$blogAdminRoute = new Zend_Controller_Router_Route(
			'admin/blog/:action/*',
			array(
				'module' => 'blog',
				'controller' => 'admin',
				'action' => 'index'
			)
			
		);
		
		$router->addRoute('blogadmin', $blogAdminRoute); // DOMAIN/admin/blog
	}
	
}