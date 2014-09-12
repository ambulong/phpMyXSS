<?php
/**
 * 保存模块
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/html; charset=utf-8' );
if (! pmx_validate_token ()) {
	die ( "Token is incorrect." );
}
$allow_cats = array (
		0,
		1,
		2 
);
$allow_onlys = array (
		0,
		1 
);

$id = isset ( $_POST ["id"] ) ? $_POST ["id"] : "";
$name = isset ( $_POST ["name"] ) ? $_POST ["name"] : "";
$desc = isset ( $_POST ["desc"] ) ? $_POST ["desc"] : "";
$cat = isset ( $_POST ["optionsCat"] ) ? $_POST ["optionsCat"] : 2;
$only = isset ( $_POST ["optionsOnly"] ) ? $_POST ["optionsOnly"] : 0;
$code = isset ( $_POST ["code"] ) ? $_POST ["code"] : "";
if ($name == "" || ! in_array ( $cat, $allow_cats ) || ! in_array ( $only, $allow_onlys )) {
	die ( "Error: Something you input is invalid." );
}

$pmxModule = new pmxModule ( $name, $desc, $cat, $only, $code );
if ($pmxModule->isExistID ( $id ) == FALSE) {
	die ( "Error: Module id is invalid." );
}
if ($pmxModule->updateMod ( $id ) == TRUE) {
	echo "Success: You have update module \"" . esc_html ( $name ) . "\" successful";
} else {
	echo "Error: Sorry. We are fail to update the module \"" . esc_html ( $name ) . "\".";
}

