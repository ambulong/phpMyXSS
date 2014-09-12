<?php
/**
 * 登录
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
$username = isset ( $_POST ['username'] ) ? $_POST ['username'] : "";
$password = isset ( $_POST ['password'] ) ? $_POST ['password'] : "";
$user = new USER ( $username, $password );
if (! $user->auth ()) {
	header ( 'Content-Type: text/plain; charset=utf-8' );
	die ( "The username or password you input is incorrect." );
}
if ($user->login ()) {
	pmx_gourl_home ();
} else {
	header ( 'Content-Type: text/plain; charset=utf-8' );
	die ( "Unknow error occured." );
}