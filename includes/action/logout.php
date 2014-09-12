<?php
/**
 * 退出登录
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}

if (pmx_validate_token ()) {
	if (session_unset ()) {
		pmx_gourl_login ();
	} else {
		header ( 'Content-Type: text/plain; charset=utf-8' );
		die ( "Unknow error occured." );
	}
} else {
	header ( 'Content-Type: text/plain; charset=utf-8' );
	die ( "Token is incorrect." );
}