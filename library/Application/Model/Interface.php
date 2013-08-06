<?php

interface Application_Model_Interface
{
/*
	public function __construct( array $options = null )
	public function __set( $name, $value )
	public function __get( $name )
	public function setOptions( array $options )
*/
	public function toArray();
	public function reset();
	public function save();
	public function delete();
}