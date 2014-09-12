<?php
/**
 * 获取模块配置
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/json; charset=utf-8' );
$id = isset ( $_GET ["id"] ) ? intval ( $_GET ["id"] ) : NULL;
$pmxModule = new pmxModule ();
$json_data = array (
		"status" => "0", // 操作状态， 0：失败 1：成功
		"msg" => "", // 提示信息
		"data" => ""  // 模块配置信息
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
$data = $pmxModule->getConfig ( $id );
$json_data = array (
		"status" => "1",
		"msg" => "success.",
		"data" => $data 
);
echo json_encode ( $json_data );
?>