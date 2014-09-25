<?php
	define( "ROOT_DIR", "/-Dark-Chimney-OPGM" );
	
	ini_set( "log_errors", 1 );
	ini_set( "display_errors", 1 ); 
	error_reporting(E_ALL);
	ini_set( "error_log", "log/error.log");
	
	require('classes/database.class.php');
	require('classes/database_object.class.php');
	require('classes/exceptions.class.php');
	require('classes/bcrypt.class.php');
	require('classes/player.class.php');
	require('classes/display.class.php');
	require('classes/controler.class.php');
	require('classes/common_lib.class.php');
	
	session_start();
	
	$page = array( "" );
	if ( isset( $_GET['path'] ) )
	{
		$path	= $_GET['path'];
		if ( $path[ strlen( $path ) - 1  ] == '/' )
			$path = substr( $path, 0, strlen( $path ) - 1 );
		
		$page = explode( "/", $path );
	}
	
	if ( isset( $_POST['vrfctn'] ) )
	{
		$controler			= new Controler();
		$controler->content	= $page[0];
		
		if ( !empty( $page[1] ) )
			$controler->subcontent	= $page[1];
			
		$controler->Process();
	}
	
	$display = new Display();
	$display->content		= $page[0];
	if ( !empty( $page[1] ) )
		$display->subcontent	= $page[1];
	if ( !empty( $page[2] ) && is_numeric( $page[2] ) )
		$display->page			= $page[2];
	$display->Render();
?>