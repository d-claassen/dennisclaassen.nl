<?php

class IndexController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{    
    $LinkedInData = $this->getLinkedInDataBySettingKeyAsXML( 'linkedin-data' );
    if( $LinkedInData )
    {
      $companies = array();
      foreach( $LinkedInData->positions->position as $position )
      {
        $companyID = strval( $position->company->id );
        if( array_key_exists( $companyID, $companies ) )
        {
          continue;
        }
        $companies[ $companyID ] = $this->getLinkedInDataBySettingKeyAsXML( 'linkedin-company-' . $companyID );
      }

      $educations = array();
      foreach( $LinkedInData->educations->education as $education )
      {
        $educationID = intval( $education->id );
        if( array_key_exists( $educationID, $educations ) )
        {
          continue;
        }
        $educations[ $educationID ] = $this->getLinkedInDataBySettingKeyAsXML( 'linkedin-education-' . $educationID );

      }

      $this->view->LinkedInUser = $LinkedInData;
      $this->view->companies = $companies;
      $this->view->educations = $educations;
    }
    $this->render( 'linkedin' );
  }

  protected function getLinkedInDataBySettingKeyAsXML( $settingKey )
  {
    $LinkedInSettingMapper = new Application_Model_Mapper_Setting();
    $LinkedInData = array_shift( $LinkedInSettingMapper->fetchBy( array( '`key` = ?' => $settingKey ) ) );
    if( !$LinkedInData )
    {
      return null;
    }
    $LinkedInData = simplexml_load_string( $LinkedInData->getValue() );

    return $LinkedInData;
  }
}