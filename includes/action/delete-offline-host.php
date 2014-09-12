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
$pmxHost = new pmxHost ();
$row = 100;
// $row = $pmxHost->delHostOffline();
if ($row) {
	echo esc_html ( "Success: You have deleted {$row} offline hosts." );
} else {
	echo esc_html ( "Fail to delete offline hosts or there have not  offline hosts." );
}