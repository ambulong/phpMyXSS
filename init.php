<?php
if (defined ( "PMX_ENTRANCE" )) {
	/**
	 * Absolute path to PMX directory
	 */
	define ( 'PMX_ABSPATH', dirname ( __FILE__ ) . '/' );
	
	define ( 'PMX_INC', 'includes/' );
	
	/**
	 * Require the configure file
	 */
	require_once (PMX_ABSPATH . 'config.php');
	
	/**
	 * Loads the environment and template
	 */
	require_once (PMX_ABSPATH . 'load.php');
	
	$pmx = new PMX ();
	$pmx->init ();
} else {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}