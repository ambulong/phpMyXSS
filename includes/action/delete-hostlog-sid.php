<?php
/**
 * 删除主机记录
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/html; charset=utf-8' );
if (! pmx_validate_token ()) {
	die ( "Error: Token is incorrect." );
}
$sid = isset ( $_GET ["sid"] ) ? $_GET ["sid"] : "";
$pmxHostLog = new pmxHostLog ();
if ($pmxHostLog->delLogBySID ( $sid )) {
	echo esc_html ( "Success: You have deleted session successful." );
}