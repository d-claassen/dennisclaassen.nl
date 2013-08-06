<?php

class Admin_Form_Acl_Role_Add extends Application_Form
{
	public function init()
  {
    $table = new Application_Model_DbTable_Acl_Role();

    $this->setMethod( Zend_Form::METHOD_POST )
    	->setLegend( 'Rol toevoegen' )
    	->setElementsBelongTo( 'roles' );

    $role = $this->createElement( 'text', 'name' );
    $role->setLabel( 'Rol' )
    	->setRequired( true )
    	->addFilter( 'StringTrim' )
    	->setDecorators( $this->defaultDecorator )
    	->addValidator( 'Db_NoRecordExists', false, array(
          'table' => $table->info( 'name' ),
    			'field' => 'name'
    		) );
    $this->addElement( $role );
    
    $parent = $this->createElement( 'select', 'parent' );
    $parent->setLabel( 'Erft rechten van' )
    	->addFilter( 'StringTrim' )
    	->setDecorators( $this->defaultDecorator );
    $this->addElement( $parent );
    
    $submit = $this->createElement( 'button', 'save-role' );
    $submit->setIgnore( true )
    	->setLabel( 'Rol opslaan' )
    	->setAttribs( array(
    			'type' => 'submit',
    			'class' => 'btn btn-primary'
    		) )
    	->setDecorators( $this->singleButtonDecorator );
    $this->addElement( $submit );
  }
}