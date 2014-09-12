<?php
/**
 * 删除某项目内的记录
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/html; charset=utf-8' );

/**
 * 校验TOKEN
 */
if (! pmx_validate_token ()) {
	die ( "Error: Token is incorrect." );
}

$id = isset ( $_GET ["id"] ) ? intval ( $_GET ["id"] ) : NULL;
$pmxProjectItem = new pmxProjectItem ();
if (! $pmxProjectItem->isExistID ( $id )) {
	die ( "Error: The item id is non-existent." );
}
if ($pmxProjectItem->delItem ( $id )) {
	echo "Success: You have deleted item {$id} successful.";
}