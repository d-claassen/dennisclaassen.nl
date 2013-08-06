<?php

class Application_Form extends Zend_Form
{
	protected $defaultDecorator = array(
		'ViewHelper',
		'Errors',
		array( array( 'content' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
		array( 'Label', array( 'class' => 'control-label' ) ),
		array( 'HtmlTag', array( 'tag' => 'div', 'class' => 'control-group' ) )
	);
	
	protected $singleButtonDecorator = array(
		'ViewHelper',
		array( 'HtmlTag', array( 'tag' => 'div', 'class' => 'form-actions' ) )
	);
	
	protected $buttonFirstDecorator = array(
		'ViewHelper',
		array( 'HtmlTag', array( 'tag' => 'div', 'class' => 'form-actions', 'openOnly' => true ) )
	);
	
	protected $buttonLastDecorator = array(
		'ViewHelper',
		array( 'HtmlTag', array( 'tag' => 'div', 'class' => 'form-actions', 'closeOnly' => true ) )
	);
	
	protected $buttonDecorator = array(
		'ViewHelper'
	);
	
	public function __construct()
	{
		// We have some new HTML5 elements in the Application library.
		// So we have to tell the form where to find these.
		// Do this before contstructing the parent, cause this calls the init function
		$this->addPrefixPath( 'Application_Form_', 'Application/Form/');

    // add the prefix path for decorators
    $this->addPrefixPath( 'Application_Form_Decorator', 'Application/Form/Decorator', 'decorator' );
		
		parent::__construct();
	}
  
  public function loadDefaultDecorators()
  {
  	$this->setAttrib( 'class', 'form-horizontal' );
  	$this->setDecorators( array(
			'FormElements',
			'Fieldset',
			'Form',
		) );
  }
    
  public function isValid( $value )
  {
  	$r = parent::isValid( $value );
  	
  	foreach( $this->_elements as $element )
  	{
  		if( $element->hasErrors() )
  		{
  			$decoratorClass = $element->getDecorator( 'HtmlTag' )
  					->getOption( 'class' );
  			if( strpos( $decoratorClass, 'clearfix' ) !== false && strpos( $decoratorClass, 'error' ) === false )
  			{
  				$element->getDecorator( 'HtmlTag' )
  					->setOption( 'class', $decoratorClass . ' error' );
  			}
  		}
  	}
  	
  	return $r;
  }
}