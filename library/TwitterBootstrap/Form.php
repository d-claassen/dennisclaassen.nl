<?php

class TwitterBootstrap_Form 
  extends Zend_Form
{
  protected $defaultDecorator = array(
    'ViewHelper',
    array( 'Errors', array( 'class' => 'help-block' ) ),
    array( 'Label', array( 'class' => 'add-on', 'escape' => false ) ),
    array( array( 'hint' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'input-prepend input-hint' ) ),
    array( 'HtmlTag', array( 'tag' => 'div', 'class' => 'control-group inline' ) )
  );
  
  protected $buttonDecorator = array(
    'ViewHelper'
  );
  
  public function __construct()
  {
    // add the prefix path for decorators
    $this->addPrefixPath( 'TwitterBootstrap_Form_Decorator', 'TwitterBootstrap/Form/Decorator', 'decorator' );
    
    parent::__construct();
  }
  
  public function loadDefaultDecorators()
  {
    $this->setDecorators( array(
      'ModalBody',
      'ModalFooter',
      array( 'ModalHeader', array( 'closeHref' => '/' ) ),
      array( 'HtmlTag', array( 'class' => 'modal' ) ),
      'Form',
    ) );
  }
    
  public function isValid( $value )
  {
    $r = parent::isValid( $value );
    
    foreach( $this->_elements as $element )
    {
      if( $decorator = $element->getDecorator( 'HtmlTag' ) )
      {
        $decoratorClass = $decorator->getOption( 'class' );
        if( $element->hasErrors() )
        {
          if( strpos( $decoratorClass, 'error' ) === false )
          {
            $decorator->setOption( 'class', $decoratorClass . ' error' );
          }
        }
        else
        {
          if( strpos( $decoratorClass, 'success' ) === false )
          {
            $decorator->setOption( 'class', $decoratorClass . ' success' );
          }
        }
      }
    }
    
    return $r;
  }
}