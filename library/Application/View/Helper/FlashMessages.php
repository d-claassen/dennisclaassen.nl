<?php

class Application_View_Helper_FlashMessages extends Zend_View_Helper_Abstract
{
  public function flashMessages()
  {
    $messages = Zend_Controller_Action_HelperBroker::getStaticHelper( 'FlashMessenger' )->getMessages();
    $output = '';
    
    if ( !empty( $messages ) )
    {
      foreach( $messages as $message )
      {
        /**
         * Expects $message to be in the form of:
         * $message = array( 'class' => 'message' )
         */
        $output .= '<div class="alert alert-' . key( $message ) . '">' . current( $message ) . '</div>';
      }
    }
    
    return $output;
  }
}