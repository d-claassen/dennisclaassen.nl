<?php

class Admin_Form_Acl_Action_Add extends Application_Form
{
	public function init()
  {
    $table = new Application_Model_DbTable_Acl_Action();

    $this->setMethod( Zend_Form::METHOD_POST )
    	->setLegend( 'Actie toevoegen' )
    	->setElementsBelongTo( 'actions' );

    $action = $this->createElement( 'text', 'action' );
    $action->setLabel( 'Actie' )
    	->setRequired( true )
    	->addFilter( 'StringTrim' )
    	->setDecorators( $this->defaultDecorator )
    	->addValidator( 'Db_NoRecordExists', false, array(
          'table' => $table->info( 'name' ),
    			'field' => 'action'
    		) );
    $this->addElement( $action );
    
    $submit = $this->createElement( 'button', 'save-action');
    $submit->setIgnore( true )
    	->setLabel( 'Actie opslaan' )
    	->setAttribs( array(
    			'type' => 'submit',
    			'class' => 'btn-primary btn'
    		) )
    	->setDecorators( $this->singleButtonDecorator );
    $this->addElement( $submit );
  }
}