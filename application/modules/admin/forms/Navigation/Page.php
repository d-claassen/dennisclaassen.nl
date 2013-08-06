<?php

class Admin_Form_Navigation_Page extends Application_Form
{
  public function init()
  {
    $moduleTable = new Application_Model_DbTable_Acl_Module();
    $controllerTable = new Application_Model_DbTable_Acl_Controller();
    $actionTable = new Application_Model_DbTable_Acl_Action();

    $this->setMethod( 'post' )
      ->setLegend( 'Pagina toevoegen' );

    $label = $this->createElement( 'text', 'label' );
    $label->setLabel( 'Label' )
      ->setRequired( true )
      ->addFilter( 'StringTrim' )
      ->setDecorators( $this->defaultDecorator );
    $this->addElement( $label );

    $parentId = $this->createElement( 'select', 'parent_id' );
    $parentId->setLabel( 'Parent' )
      ->setRequired( true )
      ->addFilter( 'StringTrim' )
      ->setDecorators( $this->defaultDecorator );
    $this->addElement( $parentId );

    $module = $this->createElement( 'text', 'module' );
    $module->setLabel( 'Module' )
      ->setRequired( true )
      ->addFilter( 'StringTrim' )
      ->setDecorators( $this->defaultDecorator )
      ->addValidator( 'Db_RecordExists', false, array(
          'table' => $moduleTable->info( 'name' ),
          'field' => 'module'
        ) );
    $this->addElement( $module );

    $controller = $this->createElement( 'text', 'controller' );
    $controller->setLabel( 'Controller' )
      ->setRequired( true )
      ->addFilter( 'StringTrim' )
      ->setDecorators( $this->defaultDecorator )
      ->addValidator( 'Db_RecordExists', false, array(
          'table' => $controllerTable->info( 'name' ),
          'field' => 'controller'
        ) );
    $this->addElement( $controller );

    $action = $this->createElement( 'text', 'action' );
    $action->setLabel( 'Actie' )
      ->setRequired( true )
      ->addFilter( 'StringTrim' )
      ->setDecorators( $this->defaultDecorator )
      ->addValidator( 'Db_RecordExists', false, array(
          'table' => $actionTable->info( 'name' ),
          'field' => 'action'
        ) );
    $this->addElement( $action );

    $visible = $this->createElement( 'checkbox', 'visible' );
    $visible->setLabel( 'Zichtbaar' )
      ->setRequired( true )
      ->addFilter( 'StringTrim' )
      ->setDecorators( $this->defaultDecorator );
    $this->addElement( $visible );

    $id = $this->createElement( 'hidden', 'id' );
    $id->setDecorators( array(
        'ViewHelper'
      ) );
    $this->addElement( $id );

    $submit = $this->createElement( 'submit', 'submit');
    $submit->setIgnore(true)
      ->setLabel( 'Opslaan' )
      ->setAttrib( 'class', 'btn btn-primary' )
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