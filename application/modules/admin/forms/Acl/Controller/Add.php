<?php

class Admin_Form_Acl_Controller_Add extends Application_Form
{	
	public function init()
  {
    $table = new Application_Model_DbTable_Acl_Controller();

    $this->setMethod( Zend_Form::METHOD_POST )
    	->setLegend( 'Controller toevoegen' )
    	->setElementsBelongTo( 'controllers' );

    $controller = $this->createElement( 'text', 'controller' );
    $controller->setLabel( 'Controller' )
    	->setRequired( true )
    	->addFilter( 'StringTrim' )
    	->setDecorators( $this->defaultDecorator )
    	->addValidator( 'Db_NoRecordExists', false, array(
    			'table' => $table->info( 'name' ),
    			'field' => 'controller'
    		) );
    $this->addElement( $controller );
    
    $submit = $this->createElement( 'button', 'save-controller');
    $submit->setIgnore( true )
    	->setLabel( 'Controller opslaan' )
    	->setAttribs( array(
    			'type' => 'submit',
    			'class' => 'btn btn-primary'
    		) )
    	->setDecorators( $this->singleButtonDecorator );
    $this->addElement( $submit );
  }
}