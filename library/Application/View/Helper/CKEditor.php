<?php

require_once LIBRARY_PATH . '/ckeditor/ckeditor.php';

class Application_View_Helper_CKEditor extends Zend_View_Helper_Abstract
{
	public function __construct()
	{
        $layout = Zend_Layout::getMvcInstance();
        
		$view = $layout->getView();
		//$view->headScript()->appendFile( '/js/ckeditor/ckeditor.js' );
	}

	/**
	 * The view helper function. Returns the final ckeditor.
	 * It has many possible options {@link http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html}
	 *
	 * @return string The HTML which renders the CKEditor
	 */
	public function ckeditor( $name, $value = "", $config = array(), $events = array() )
	{
		$ckeditor = new CKEditor();
		
		$ckeditor->basePath = '/js/ckeditor/';
		$ckeditor->config = $config;

		return $ckeditor->editor( $name, $value );
	}
}