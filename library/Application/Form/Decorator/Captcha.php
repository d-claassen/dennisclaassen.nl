<?php

class Application_Form_Decorator_Captcha extends Zend_Form_Decorator_Captcha
{
  public function render( $content )
  {
    $element = $this->getElement();
    if( !method_exists( $element, 'getCaptcha' ) )
    {
      return $content;
    }

    $view = $element->getView();
    if ( $view === null )
    {
      return $content;
    }

    $name = $element->getFullyQualifiedName();

    $hiddenName = $name . '[id]';
    $textName = $name . '[input]';

    $label = $element->getDecorator( "Label" );
    if( $label )
    {
      $label->setOption( "id", $element->getId() . "-input" );
    }

    $placement = $this->getPlacement();
    $separator = $this->getSeparator();

    $captcha = $element->getCaptcha();
    $markup = $captcha->render( $view, $element );
    $hidden = $view->formHidden( $hiddenName, $element->getValue(), $element->getAttribs() );
    $text = $view->formText( $textName, '', $element->getAttribs() );

    switch ($placement)
    {
      case 'PREPEND':
        return $text . $markup . $hidden . $separator . $content;
      case 'APPEND':
      default:
        return $content . $separator . $text . $hidden . $markup;
      }
  }
}