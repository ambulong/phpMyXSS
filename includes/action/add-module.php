<?php
/**
 * 添加模块处理模块
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
); // 允许的分类值
$allow_onlys = array (
		0,
		1 
); // 允许的ONLY值

$name = isset ( $_POST ["name"] ) ? $_POST ["name"] : "";
$desc = isset ( $_POST ["desc"] ) ? $_POST ["desc"] : "";
$cat = isset ( $_POST ["optionsCat"] ) ? $_POST ["optionsCat"] : 2;
$only = isset ( $_POST ["optionsOnly"] ) ? $_POST ["optionsOnly"] : 0;
$code = isset ( $_POST ["code"] ) ? $_POST ["code"] : "";

/**
 * 校验输入信息是否完整和正常
 */
if ($name == "" || ! in_array ( $cat, $allow_cats ) || ! in_array ( $only, $allow_onlys )) {
	die ( "Error: Something you input is invalid." );
}

/**
 * 检查文件代码是否包括系统模块关键字
 */
if (strpos ( $code, "pmx.system.module." )) {
	die ( "Error: The code contain invalid string." );
}

$pmxModule = new pmxModule ( $name, $desc, $cat, $only, $code );

/**
 * 模块名称是否已经存在
 */
if ($pmxModule->isExistName ( $name ) == TRUE) {
	die ( "Error: Duplicate module name." );
}

/**
 * 添加模块
 */
if ($pmxModule->addMod () == TRUE) {
	echo "Success: You have add module \"" . esc_html ( $name ) . "\" successful";
} else {
	echo "Error: Sorry. We are fail to add the module \"" . esc_html ( $name ) . "\".";
}

