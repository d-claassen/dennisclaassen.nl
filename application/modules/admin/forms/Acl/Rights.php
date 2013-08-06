<?php

class Admin_Form_Acl_Rights extends Application_Form
{
	protected $defaultDecorator = array(
		'ViewHelper',
		'Errors',
		array( array( 'content' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
		array( 'Label', array( 'class' => 'control-label' ) ),
		array( 'HtmlTag', array( 'tag' => 'div', 'class' => 'control-group' ) )
	);
	
	public function init()
  {
    $this->setMethod( Zend_Form::METHOD_POST )
    	->setLegend( 'Rechten' )
    	->setElementsBelongTo( 'rights' )
  		->setAttrib( 'class', 'form-horizontal' );
	
		$role = $this->createElement( 'select', 'role_id' );
    $role->setLabel( 'Rol' )
    	->setRequired( true )
    	->addFilter( 'StringTrim' )
    	->setDecorators( $this->defaultDecorator );
    $this->addElement( $role );
        
    $module = $this->createElement( 'select', 'module_id' );
    $module->setLabel( 'Module' )
    	->setRequired( true )
    	->addFilter( 'StringTrim' )
    	->setDecorators( $this->defaultDecorator );
    $this->addElement( $module );
        
    $controller = $this->createElement( 'select', 'controller_id' );
    $controller->setLabel( 'Controller' )
    	->setRequired( true )
    	->addFilter( 'StringTrim' )
    	->setDecorators( $this->defaultDecorator );
    $this->addElement( $controller );
                
    $action = $this->createElement( 'select', 'action_id' );
    $action->setLabel( 'Actie' )
    	->setRequired( true )
    	->addFilter( 'StringTrim' )
    	->setDecorators( $this->defaultDecorator );
    $this->addElement( $action );
        
		$type = $this->createElement( 'select', 'type' );
    $type->setLabel( 'Type' )
    	->setRequired( true )
    	->addFilter( 'StringTrim' )
    	->setDecorators( $this->defaultDecorator );
    $this->addElement( $type );
        
            
    $submit = $this->createElement( 'button', 'save' );
    $submit->setIgnore( true )
    	->setLabel( 'Verzenden' )
    	->setAttribs( array(
    			'type' => 'submit',
    			'class' => 'btn-primary btn'
    		) )
    	->setDecorators( $this->buttonFirstDecorator );
    $this->addElement( $submit );
        
    $reset = $this->createElement( 'button', 'reset' );
    $reset->setIgnore( true )
    	->setLabel( 'Reset' )
    	->setAttribs( array(
    			'type' => 'reset',
    			'class' => 'btn'
    		) )
    	->setDecorators( $this->buttonLastDecorator );
    $this->addElement( $reset );

    }
}