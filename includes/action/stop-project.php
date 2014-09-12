<?php
/**
 * 停止项目
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/html; charset=utf-8' );
if (! pmx_validate_token ()) {
	die ( "Error: Token is incorrect." );
}
$id = isset ( $_GET ["id"] ) ? intval ( $_GET ["id"] ) : NULL;
$pmxProj = new pmxProject ();
if (! $pmxProj->isExistID ( $id )) {
	die ( "Error: The project id is non-existent." );
}
if ($pmxProj->stopProj ( $id )) {
	echo "Success: You have stoped the project {$id} successful.";
}