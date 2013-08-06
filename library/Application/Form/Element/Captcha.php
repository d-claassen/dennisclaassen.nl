<?php

class Application_Form_Element_Captcha extends Zend_Form_Element_Captcha
{
  public function render( Zend_View_Interface $view = null )
  {
    $captcha = $this->getCaptcha();
    $captcha->setName( $this->getFullyQualifiedName() );

    $decorators = $this->getDecorators();

    $decorator = new Application_Form_Decorator_Captcha( array( 'captcha' => $captcha ) );
    array_unshift( $decorators, $decorator );

    $decorator = $captcha->getDecorator();

    $this->setDecorators( $decorators );

    $this->setValue( $this->getCaptcha()->generate() );


    $result = Zend_Form_Element::render( $view );

    return $result;
  }
}