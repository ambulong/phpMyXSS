<?php
/**
 * 删除模块
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
$pmxModule = new pmxModule ();
if (! $pmxModule->isExistID ( $id )) {
	die ( "Error: The module id is non-existent." );
}
if ($pmxModule->delMod ( $id )) {
	echo "Success: You have deleted module {$id} successful.";
}