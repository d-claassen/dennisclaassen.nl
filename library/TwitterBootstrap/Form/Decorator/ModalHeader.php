<?php


class TwitterBootstrap_Form_Decorator_ModalHeader
  extends Zend_Form_Decorator_Fieldset
{
  public function render( $content )
  {
    $element = $this->getElement();
    $view    = $element->getView();
    if ($view === null)
    {
      return $content;
    }

    $legend  = $this->getLegend();
    $attribs = $this->getOptions();
    $name    = $element->getFullyQualifiedName();
    $id      = (string)$element->getId();

    if( !array_key_exists( 'id', $attribs ) && $id !== '' )
    {
      $attribs[ 'id' ] = 'header-' . $id;
    }

    if( array_key_exists( 'class', $attribs ) && $attribs[ 'class' ] !== '' )
    {
      if( strpos( $attribs[ 'class' ], 'modal-header' ) === false )
      {
        $attribs[ 'class' ] .= ' modal-header';
      }
    }
    else
    {
      $attribs[ 'class' ] = 'modal-header';
    }

    if (null !== $legend)
    {
      if( ( $translator = $element->getTranslator() ) !== null )
      {
        $legend = $translator->translate( $legend );
      }

      $attribs[ 'legend' ] = $legend;
    }

    foreach( array_keys( $attribs ) as $attrib )
    {
      $testAttrib = strtolower( $attrib );
      if( in_array( $testAttrib, $this->stripAttribs ) )
      {
        unset( $attribs[ $attrib ] );
      }
    }

    return $view->modalHeader( $name, $content, $attribs );
  }
}