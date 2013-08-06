<?php

class Admin_LinkedInController extends Zend_Controller_Action
{
  public function indexAction()
  {
    $user = Zend_Registry::get('user');

    if ( !$user->isLoggedIn() )
    {
      $this->_redirect( $this->view->url( array(
          'controller' => 'user',
          'action' => 'login'
        ) ) );
    }

    $SettingsMapper = new Application_Model_Mapper_Setting();
    $LinkedInData = array_shift( $SettingsMapper->fetchByKey( 'linkedin-data' ) );

//    $this->view->xml = $LinkedInData->getValue();
//    $this->view->lastFetch = time();
  }

  public function refreshAction()
  {
    $SettingsMapper = new Application_Model_Mapper_Setting();
    $LinkedInSetting = array_shift( $SettingsMapper->fetchByKey( 'linkedin' ) );

    $linkedInOptions = array(
      'consumerKey' => 't137xq7do864',
      'consumerSecret' => 'KCqqDRhmdKdkz2PB',
      );
    if( $LinkedInSetting )
    {
      $linkedInOptions[ 'accessToken' ] = unserialize( $LinkedInSetting->getValue() );
    }
    $LinkedIn = new Application_Service_LinkedIn( $linkedInOptions );
    if( !$LinkedIn->isAuthorized() )
    {
      $this->_redirect( $this->view->url( array( 'action' => 'authorize' ) ) );
    }
    
    // get data from linkedin
    $LinkedInUser = $LinkedIn->userProfile( false, true );
    $this->saveSetting( 'linkedin-data', $LinkedInUser->getIterator()->asXML() );

    $companies = array();
    foreach( $LinkedInUser->getIterator()->positions->position as $position )
    {
      $companyID = strval( $position->company->id );
      if( in_array( $companyID, $companies ) )
      {
        continue;
      }
      $companies[] = $companyID;
      $LinkedInCompany = $LinkedIn->company( $companyID, true );
      $this->saveSetting( 'linkedin-company-' . $companyID, $LinkedInCompany->getIterator()->asXML() );
    }

    $educations = array();
    foreach( $LinkedInUser->getIterator()->educations->education as $education )
    {
      $companyName = strtolower( str_replace( ' ', '-', preg_replace( '/[,.:]/', '', strval( $education->{'school-name'} ) ) ) );
      if( in_array( $companyName, $educations ) )
      {
        continue;
      }
      $educations[] = $companyName;
      $LinkedInCompany = $LinkedIn->company( 'universal-name=' . $companyName, true );

      // Make sure the website URL starts with http://
      if( strval( $LinkedInCompany->getIterator()->{'website-url'} ) != '' && strpos( strval( $LinkedInCompany->getIterator()->{'website-url'} ), 'http' ) === false )
      {
        $LinkedInCompany->getIterator()->{'website-url'} = 'http://' . $LinkedInCompany->getIterator()->{'website-url'};
      }

      $this->saveSetting( 'linkedin-education-' . intval( $education->id ), $LinkedInCompany->getIterator()->asXML() );
    }

    $this->_redirect( $this->view->url( array( 'action' => 'index' ) ) );
  }

  protected function saveSetting( $key, $value )
  {
    $SettingsMapper = new Application_Model_Mapper_Setting();
    // save data to database
    $Setting = array_shift( $SettingsMapper->fetchByKey( $key ) );
    if( $Setting )
    {
      $Setting->delete();
    }

    $Setting = new Application_Model_Setting();
    $Setting->setKey( $key );
    $Setting->setValue( $value );
    return $Setting->save();
  }

  public function authorizeAction()
  {
    $LinkedInSession = new Zend_Session_Namespace( 'linkedin' );
    $linkedInOptions = array(
      'callbackUrl' => 'http://' . DOMAIN . '/admin/linkedin/authorize',
      'consumerKey' => 't137xq7do864',
      'consumerSecret' => 'KCqqDRhmdKdkz2PB',
    );
    if( isset( $LinkedInSession->accessToken ) )
    {
      $options[ 'accessToken' ] = unserialize( $LinkedInSession->accessToken );
    }

    $LinkedIn = new Application_Service_LinkedIn( $linkedInOptions );
    if( !$LinkedIn->isAuthorized() )
    {
      if( count( $_GET ) && isset( $LinkedInSession->requestToken ) )
      {
        $token = $LinkedIn->getAccessToken( $_GET, unserialize( $LinkedInSession->requestToken ) );
        $LinkedInSession->accessToken = serialize( $token );
        unset( $LinkedInSession->requestToken );

        $SettingsMapper = new Application_Model_Mapper_Setting();
        $LinkedInSettings = $SettingsMapper->fetchByKey( 'linkedin' );
        foreach( $LinkedInSettings as $LinkedInSetting )
        {
          $LinkedInSetting->delete();
        }

        $LinkedInSetting = new Application_Model_Setting();
        $LinkedInSetting->setKey( 'linkedin' );
        $LinkedInSetting->setValue( $LinkedInSession->accessToken );
        $LinkedInSetting->save();

        $this->_redirect( $_SERVER[ 'HTTP_REFERER' ] );
      }
      else
      {
        $token = $LinkedIn->getRequestToken( array( 'scope' => 'r_fullprofile' ) );
        $LinkedInSession->requestToken = serialize( $token );
        $LinkedIn->redirect();
      }
    }
  }
}