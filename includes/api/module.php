<?php
/**
 * 获取模块详细信息
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/json; charset=utf-8' );
$id = isset ( $_GET ["id"] ) ? intval ( $_GET ["id"] ) : NULL;
$pmxModule = new pmxModule ();
$json_data = array (
		"status" => "0",
		"msg" => "",
		"data" => "" 
);
if (! pmx_validate_token ()) {
	$json_data = array (
			"status" => "0",
			"msg" => "Token is incorrect.",
			"data" => "" 
	);
	die ( json_encode ( $json_data ) );
}
if (! $pmxModule->isExistID ( $id )) {
	$json_data = array (
			"status" => "0",
			"msg" => "The module id is non-existent.",
			"data" => "" 
	);
	die ( json_encode ( $json_data ) );
}
$data = $pmxModule->getDetail ( $id );
$json_data = array (
		"status" => "1",
		"msg" => "success.",
		"data" => $data 
);
echo json_encode ( $json_data );
?>