<?php

class TwitterBootstrap_Form_Decorator_ModalFooter
  extends Zend_Form_Decorator_FormElements
{
  protected $skipElements = array(
      'Zend_Form_Element_Button',
      'Zend_Form_Element_Reset',
      'Zend_Form_Element_Submit'
    );
  
  public function render( $content )
  {
    $form    = $this->getElement();
    if( ( !$form instanceof Zend_Form ) && ( !$form instanceof Zend_Form_DisplayGroup ) )
    {
      return $content;
    }

    $belongsTo      = ( $form instanceof Zend_Form ) ? $form->getElementsBelongTo() : null;
    $elementContent = '';
    $separator      = $this->getSeparator();
    $translator     = $form->getTranslator();
    $items          = array();
    $view           = $form->getView();
    foreach( $form as $item )
    {
      if( !in_array( get_class( $item ),  $this->skipElements ) )
      {
        continue;
      }

      $item->setView( $view )
        ->setTranslator( $translator );
      if( $item instanceof Zend_Form_Element )
      {
        $item->setBelongsTo( $belongsTo );
      }
      elseif( !empty( $belongsTo ) && ( $item instanceof Zend_Form ) )
      {
        if( $item->isArray() )
        {
          $name = $this->mergeBelongsTo( $belongsTo, $item->getElementsBelongTo() );
          $item->setElementsBelongTo( $name, true );
        }
        else
        {
          $item->setElementsBelongTo( $belongsTo, true );
        }
      }
      elseif( !empty( $belongsTo ) && ( $item instanceof Zend_Form_DisplayGroup ) )
      {
        foreach( $item as $element )
        {
          $element->setBelongsTo( $belongsTo );
        }
      }

      $items[] = $item->render();

      if( ($item instanceof Zend_Form_Element_File )
        || ( ( $item instanceof Zend_Form )
          && ( Zend_Form::ENCTYPE_MULTIPART == $item->getEnctype() ) )
        || ( ( $item instanceof Zend_Form_DisplayGroup )
          && ( Zend_Form::ENCTYPE_MULTIPART == $item->getAttrib('enctype') ) )
      )
      {
        if( $form instanceof Zend_Form )
        {
          $form->setEnctype( Zend_Form::ENCTYPE_MULTIPART );
        }
        elseif( $form instanceof Zend_Form_DisplayGroup )
        {
          $form->setAttrib( 'enctype', Zend_Form::ENCTYPE_MULTIPART );
        }
      }
    }
    $elementContent = '<div class="modal-footer">'
      . implode( $separator, $items )
      . '</div>';

    switch( $this->getPlacement() )
    {
      case self::PREPEND:
        return $elementContent . $separator . $content;
      case self::APPEND:
      default:
        return $content . $separator . $elementContent;
    }
  }
}