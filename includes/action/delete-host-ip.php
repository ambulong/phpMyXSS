<?php
/**
 * 删除主机(IP)
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/html; charset=utf-8' );
if (! pmx_validate_token ()) {
	die ( "Error: Token is incorrect." );
}
$ip = isset ( $_GET ["ip"] ) ? $_GET ["ip"] : "";
$pmxHost = new pmxHost ();
if (! $pmxHost->isExistIP ( $ip )) {
	die ( "Error: The IP is non-existent." );
}
if ($pmxHost->delHostIP ( $ip )) {
	echo esc_html ( "Success: You have deleted IP {$ip} successful." );
}