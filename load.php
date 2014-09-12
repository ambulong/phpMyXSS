<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}

require_once (PMX_ABSPATH . PMX_INC . 'load.php');
require_once (PMX_ABSPATH . PMX_INC . 'functions.php');
require_once (PMX_ABSPATH . PMX_INC . 'autoload.php');

pmx_debug_mode ();
pmx_check_php_mysql ();
date_default_timezone_set ( PMX_TIMEZONE );
if (! is_session_started ())
	session_start ();