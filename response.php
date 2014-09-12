<?php
/** Prevent user from loading inc. file */
define ( "PMX_ENTRANCE", true );

require (dirname ( __FILE__ ) . '/public-init.php');
header ( "Access-Control-Allow-Origin:*" );
$current_url = get_url ();
$URI = substr ( $current_url, strlen ( PMX_SITEURL ), strlen ( $current_url ) - strlen ( PMX_SITEURL ) );
$uri = explode ( '/', $URI );
if (count ( $uri ) < 4) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
$sid = $uri [2];
$saltid = $uri [3];
(new pmxHostLog ())->addResp ( $saltid, json_encode ( $_REQUEST ) );
header ( "HTTP/1.0 404 Not Found" );
exit ();