<?php

class Admin_Form_Acl_Module_Add extends Application_Form
{
	public function init()
  {
    $table = new Application_Model_DbTable_Acl_Module();

    $this->setMethod( Zend_Form::METHOD_POST )
    	->setLegend( 'Module toevoegen' )
    	->setElementsBelongTo( 'modules' );

    $module = $this->createElement( 'text', 'module' );
    $module->setLabel( 'Module' )
    	->setRequired( true )
    	->addFilter( 'StringTrim' )
    	->setDecorators( $this->defaultDecorator )
    	->addValidator( 'Db_NoRecordExists', false, array(
          'table' => $table->info( 'name' ),
    			'field' => 'module'
    		) );
    $this->addElement( $module );
    
    $submit = $this->createElement( 'button', 'save-module');
    $submit->setIgnore( true )
    	->setLabel( 'Module opslaan' )
    	->setAttribs( array(
    			'type' => 'submit',
    			'class' => 'btn btn-primary'
    		) )
    	->setDecorators( $this->singleButtonDecorator );
    $this->addElement( $submit );
  }
}