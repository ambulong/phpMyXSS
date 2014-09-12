<?php
/**
 * 添加命令
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
if (! pmx_validate_token ()) {
	die ( "Token is incorrect." );
}
$addType_allow = array (
		"normal",
		"module" 
); // 允许的类型
$mid_deny = array (
		40,
		34,
		31 
); // 禁止使用的模块

$sid = isset ( $_REQUEST ['sid'] ) ? $_REQUEST ['sid'] : "";
$addType = isset ( $_REQUEST ['type'] ) ? strtolower ( $_REQUEST ['type'] ) : "";
$command = "";
if (! in_array ( $addType, $addType_allow )) {
	json_out ( 0, "Type is invalid." );
}
if (! (new pmxHost ())->isExistSaltID ( $sid )) {
	json_out ( 0, "SID is non-existent." );
}
if ($addType == "normal") {
	$command = isset ( $_REQUEST ['command'] ) ? $_REQUEST ['command'] : "";
	if (trim ( $command ) == "")
		json_out ( 1, "Command is empty." );
	$pmxHostLog = new pmxHostLog ();
	$hostLogSaltID = $pmxHostLog->newSaltID ();
	/**
	 * 命令的名字
	 */
	$cname = $command;
	if ($pmxHostLog->addCommand ( $sid, $cname, $command, $hostLogSaltID ))
		json_out ( 1, "Success.", $command );
	else
		json_out ( 0, "False." );
} else {
	$mid = isset ( $_REQUEST ['mid'] ) ? $_REQUEST ['mid'] : "";
	$mconfig = isset ( $_REQUEST ['data'] ) ? $_REQUEST ['data'] : ""; // 用户提交的模块参数
	if ($mconfig != "") {
		if (! is_json ( $mconfig ))
			json_out ( 0, "The module configure is invalid." );
		$mconfig = json_decode ( $mconfig, TRUE ); // array(参数名， 参数值)
	} else {
		$mconfig = array ();
	}
	
	/**
	 * 模块是否可使用
	 */
	if (in_array ( $mid, $mid_deny )) {
		json_out ( 0, "The module you have selected is only for project." );
	}
	
	/**
	 * 模块是否存在
	 */
	if (! (new pmxModule ())->isExistID ( $mid )) {
		json_out ( 0, "The module id is non-existent." );
	}
	$mconfig_sys = (new pmxModule ())->getConfig ( $mid ); // 模块的参数
	
	/**
	 * 校验用户提交的模块参数是否完整
	 */
	if (validate_addcommand_mod_config ( $mconfig, $mconfig_sys )) {
		$pmxHostLog = new pmxHostLog ();
		$hostLogSaltID = $pmxHostLog->newSaltID ();
		
		/**
		 * 命令的名字
		 */
		$modDetail = (new pmxModule ())->getDetail ( $mid );
		$cname = "( " . $modDetail ["name"] . " )";
		if (count ( $mconfig ) > 0)
			$cname = "( " . $modDetail ["name"] . " )  " . addcommand_cname_config ( $mconfig );
		
		/**
		 * 校正参数数据信息
		 */
		$mconfig = correct_addcommand_mod_config ( $sid, $mconfig, $hostLogSaltID );
		// var_dump($mconfig);
		/**
		 * 获取整合参数后的代码
		 */
		$command = (new pmxModule ())->getConfigedCode ( $mid, $mconfig );
		
		/**
		 * 添加代码
		 */
		if ($pmxHostLog->addCommand ( $sid, $cname, $command, $hostLogSaltID ))
			json_out ( 1, "Success.", $command );
		else
			json_out ( 0, "False." );
	} else {
		json_out ( 0, "Config is invalid." );
	}
}
function json_out($status = 0, $msg = "", $data = "") {
	header ( 'Content-Type: text/json; charset=utf-8' );
	die ( json_encode ( array (
			"status" => "{$status}",
			"msg" => "{$msg}",
			"data" => $data 
	) ) );
}

/**
 * 校验用户提交的模块参数是否完整
 * 
 * @param unknown $config
 *        	用户提交的模块参数
 * @param unknown $config_temp
 *        	系统中的模块参数
 * @return boolean
 */
function validate_addcommand_mod_config($config, $config_sys) {
	if (! count ( $config_sys ) > 0)
		return TRUE;
	if (! count ( $config ) > 0)
		return FALSE;
	$config_var = array ();
	$config_sys_var = array ();
	foreach ( $config as $config_item ) {
		$config_var [] = $config_item [0];
	}
	foreach ( $config_sys as $config_sys_item ) {
		if (! in_array ( $config_sys_item [0], $config_var )) {
			json_out ( 0, "The module config var [" . $config_sys_item [0] . "](" . $config_sys_item [1] . ") could not be NULL." );
			return FALSE;
		}
	}
	return TRUE;
}

/**
 * 校正参数数据信息
 * 
 * @param unknown $sid        	
 * @param unknown $config        	
 * @param string $saltid        	
 * @return unknown|multitype:multitype:string unknown multitype:string multitype:string Ambigous <>
 */
function correct_addcommand_mod_config($sid, $config, $saltid = "") {
	$config_temp = array ();
	if (count ( $config ) > 0) {
		foreach ( $config as $config_item ) {
			$config_temp [] = array (
					"search" => "{pmx.define." . $config_item [0] . "}",
					"replace" => $config_item [1] 
			);
		}
	}
	$hostDetail = (new pmxHost ())->getDetail ( $sid );
	$pid = $hostDetail ["pid"];
	$projDetail = (new pmxProject ())->getDetail ( $pid );
	$config_temp [] = array (
			"search" => "{pmx.system.projid}",
			"replace" => $projDetail ["saltid"] 
	);
	$config_temp [] = array (
			"search" => "{pmx.system.projurl}",
			"replace" => (new pmxURL ())->get_response_puburl ( $sid, $saltid . "/" ) 
	);
	return $config_temp;
}
function addcommand_cname_config($config) {
	if (! count ( $config ) > 0)
		return FALSE;
	$data = " ";
	foreach ( $config as $config_item ) {
		$data = $data . "--" . $config_item [0] . "=" . $config_item [1] . " ";
	}
	return $data;
}