<?php

class Application_Model_Setting extends Application_Model_Abstract
{
  const IDENTIFIER_FIELD = 'key';

  protected $key = '',
    $value = '';

  public function reset()
  {
    $this->key = '';
    $this->value = '';
  }

  public function getKey()
  {
    return $this->key;
  }

  public function setKey( $key )
  {
    $this->key = $key;
    return $this;
  }

  public function getValue()
  {
    return $this->value;
  }

  public function setValue( $value )
  {
    $this->value = $value;
    return $value;
  }
}