<?php
/** Prevent user from loading inc. file */
define ( "PMX_ENTRANCE", true );

require (dirname ( __FILE__ ) . '/public-init.php');

$current_url = get_url ();
$URI = substr ( $current_url, strlen ( PMX_SITEURL ), strlen ( $current_url ) - strlen ( PMX_SITEURL ) );
if(substr($URI, 0, 1) !== '/')
                        $URI = '/'.$URI;
$uri = explode ( '/', $URI );
$saltid = substr ( $uri [2], 0, 8 );

$pmxProj = new pmxProject ();
if ($pmxProj->isExistSaltID ( $saltid ) == FALSE) {
	header ( 'Content-Type: text/javascript; charset=utf-8' );
	die ( "/*null*/" );
}
$id = $pmxProj->getIDbySlatID ( $saltid );
$detail = $pmxProj->getDetail ( $id );
$mods = json_decode ( $detail ['mods'], true );
if ($detail ['status'] == 0) {
	header ( 'Content-Type: text/javascript; charset=utf-8' );
	die ( "/*null*/" );
}
$code = $pmxProj->getCode ( $id );

if (count ( $mods ) == 1 && strpos ( $code, "{pmx.system.module." )) { // 判断是否为系统模块
	$mod_httpauth_id = 34;
	$mod_srcredirection_id = 31;
	$mod_config = $pmxProj->getConfig ( $id );
	if (strpos ( $code, "{pmx.system.module.httpauth}" )) {
		$info = "";
		if (count ( $mod_config ) > 0) {
			foreach ( $mod_config as $mod_config_item ) {
				if ($mod_config_item [0] == $mod_httpauth_id && $mod_config_item [1] == "info") {
					$info = $mod_config_item [2];
					break;
				}
			}
		}
		header ( 'WWW-Authenticate: Basic realm="' . $info . '"' );
		$username = isset ( $_SERVER ['PHP_AUTH_USER'] ) ? $_SERVER ['PHP_AUTH_USER'] : "";
		$password = isset ( $_SERVER ['PHP_AUTH_PW'] ) ? $_SERVER ['PHP_AUTH_PW'] : "";
		$url = ((new pmxURL ())->get_request_puburl ( $saltid )) . "?PHP_AUTH_USER=" . urlencode ( $username ) . "&PHP_AUTH_PW=" . urlencode ( $password );
		// echo $url;
		if (isset ( $_SERVER ['PHP_AUTH_USER'] )) {
			header ( "location:" . $url );
		}
	} elseif (strpos ( $code, "{pmx.system.module.srcredirection}" )) {
		$url = "";
		foreach ( $mod_config as $mod_config_item ) {
			if ($mod_config_item [0] == $mod_srcredirection_id && $mod_config_item [1] == "url") {
				$url = $mod_config_item [2];
				break;
			}
		}
		if ($url != "") {
			header ( "location:" . $url );
		}
	}
} else {
	header ( 'Content-Type: text/javascript; charset=utf-8' );
	if ($detail ['protection'] == 0) {
		echo $code;
	} else {
		$packer = new JavaScriptPacker ( $code, 'Normal', true, false );
		$packed = $packer->pack ();
		echo $packed;
	}
}