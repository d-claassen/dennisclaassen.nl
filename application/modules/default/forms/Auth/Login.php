<?php

class Default_Form_Auth_Login extends Application_Form
{

	public function init()
	{
		$this->setMethod( 'post' )
			->setLegend( 'Aanmelden' );

		$username = $this->createElement( 'text', 'username' );
		$username->setRequired( true )
			->setLabel( 'Gebruikersnaam' )
			->addFilter( 'StringTrim' )
			->setDecorators( $this->defaultDecorator );
		$this->addElement($username);

		$password = $this->createElement( 'password', 'password' );
		$password->setRequired( true )
			->setLabel( 'Wachtwoord' )
			->setDecorators( $this->defaultDecorator );
		$this->addElement( $password );

		$submit = $this->createElement( 'submit', 'submit');
		$submit->setIgnore(true)
			->setLabel( 'Aanmelden' )
			->setAttrib( 'class', 'btn primary' )
			->setDecorators( $this->singleButtonDecorator );
		$this->addElement($submit);

	}

}