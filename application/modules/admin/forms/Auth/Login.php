<?php

class Admin_Form_Auth_Login extends TwitterBootstrap_Form
{
	public function init()
	{
		$this->setMethod( 'post' )
			->setLegend( 'Aanmelden' )
			->setAttrib( 'class', 'form-inline form-login' );
      
		$username = $this->createElement( 'text', 'username' );
		$username->setLabel( '<i class="icon-user"></i>' )
			->addFilter( 'StringTrim' )
			->setDecorators( $this->defaultDecorator )
      ->setRequired( true )
      ->addValidator( 'Db_RecordExists', true, array(
        'table' => 'users',
        'field' => 'username'
      ) )
      ->setAttrib( 'autofocus', 'autofocus' );
		$this->addElement( $username );
		
		$password = $this->createElement( 'password', 'password' );
		$password->setLabel( '<i class="icon-lock"></i>' )
			->setDecorators( $this->defaultDecorator )
      ->setRequired( true )
      ->addValidator( 'Login', true, array( 
        'table' => 'users',
        'identity' => 'username',
        'password' => 'password',
        'hash' => 'SHA1(CONCAT(salt,?))',
        'identityField' => 'username'
      ) )
      ->addPrefixPath( 'Application_Validate', 'Application/Validate/', 'validate' );
		$this->addElement( $password );

		$submit = $this->createElement( 'submit', 'submit');
		$submit->setIgnore(true)
			->setLabel( 'Aanmelden' )
			->setAttrib( 'class', 'btn btn-primary' )
			->setDecorators( $this->buttonDecorator );
		$this->addElement( $submit );
	}
}