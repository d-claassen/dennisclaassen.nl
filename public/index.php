<?php

// goes away in a production
error_reporting( E_ALL );

define( 'DEV_SERVER', 'dennis.local' );
define( 'LIVE_SERVER', 'dennisclaassen.nl' );

// define BASE_PATH constant
define( 'BASE_PATH', dirname( dirname( __FILE__ ) ) );

// define LIBRARY_PATH constant
define( 'LIBRARY_PATH', BASE_PATH . '/library' );

// Define path to application directory
defined( 'APPLICATION_PATH' ) || define( 'APPLICATION_PATH',
		realpath( dirname( __FILE__ ) . '/../application' ) );

// Define application environment
defined( 'APPLICATION_ENV' ) || define( 'APPLICATION_ENV',
		( getenv( 'APPLICATION_ENV' ) ? getenv( 'APPLICATION_ENV' ) : 'development' ) );

defined( 'PUBLIC_PATH' ) || define( 'PUBLIC_PATH',
    realpath( dirname( __FILE__ ) . '/../public' ) );

if( setlocale( LC_ALL, 'nl_NL' ) === false )
{
  setlocale( LC_ALL, 'nld_nld' );
}

// define DOMAIN constant
define( 'DOMAIN', 
		( getenv( 'APPLICATION_ENV' ) == 'development' ) ? DEV_SERVER : LIVE_SERVER );

set_include_path( implode( PATH_SEPARATOR, array(
		dirname( dirname( __FILE__ ) ) . '/library',
		get_include_path(),
) ) );

require( LIBRARY_PATH . '/Zend/Loader/Autoloader.php' );
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace( 'Application_' )
  ->registerNamespace( 'TwitterBootstrap_' );


// Create application, bootstrap, and run
$application = new Zend_Application(
		APPLICATION_ENV,
		APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap()
	->run();
