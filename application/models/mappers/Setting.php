<?php

class Application_Model_Mapper_Setting extends Application_Model_Mapper_Abstract
{
  public function save( Application_Model_Interface $model )
  {
    $this->getDbTable()->insert( $model->toArray() );
  }
}