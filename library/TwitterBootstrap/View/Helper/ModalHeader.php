<?php

class TwitterBootstrap_View_Helper_ModalHeader
  extends Zend_View_Helper_FormElement
{
  public function modalHeader($name, $content, $attribs = null)
  {
    $info = $this->_getInfo($name, $content, $attribs);
    extract($info);

    // get legend
    $legend = '';
    if( isset( $attribs[ 'legend' ] ) )
    {
      $legendString = trim( $attribs[ 'legend' ] );
      if( !empty( $legendString ) )
      {
        $legend = '<h3>'
          . ( ( $escape ) ? $this->view->escape( $legendString ) : $legendString )
          . '</h3>' . PHP_EOL;
      }
      unset( $attribs[ 'legend' ] );
    }

    $close = '<a class="close" '
      . 'href="' . ( ( array_key_exists( 'closeHref', $attribs ) ) ? $attribs[ 'closeHref' ] : '#' ) . '"'
      . '>'
      . '&times;'
      . '</a>' ;
    if( array_key_exists( 'closeHref', $attribs ) )
    {
      unset( $attribs[ 'closeHref' ] );
    }

    // get id
    if( !empty( $id ) )
    {
      $id = ' id="' . $this->view->escape( $id ) . '"';
    }
    else
    {
      $id = '';
    }

    // render fieldset
    $xhtml = '<div'
    . $id
    . $this->_htmlAttribs( $attribs )
    . '>'
    . $close
    . $legend
    . '</div>'
    . $content;

    return $xhtml;
  }
}