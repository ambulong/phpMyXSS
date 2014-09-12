<?php
/**
 * 用户是否登录
 * @return bool
 */
function pmx_is_login() {
	if (isset ( $_SESSION ["pmx_user"] )) {
		if ($_SESSION ["pmx_user"] == PMX_USERNAME) {
			return TRUE;
		} else {
			return FALSE;
		}
	} else {
		return FALSE;
	}
}
/**
 * 获取当前用户用户名
 * 
 * @return string
 */
function pmx_get_username() {
	if (! isset ( $_SESSION ['pmx_user'] )) {
		return NULL;
	}
	return $_SESSION ["pmx_user"];
}

/**
 * 校验TOKEN
 * 
 * @return boolean
 */
function pmx_validate_token() {
	if (! isset ( $_REQUEST ['token'] )) {
		return FALSE;
	}
	$token = isset ( $_REQUEST ['token'] ) ? $_REQUEST ['token'] : "";
	if (md5 ( $_SESSION ["pmx_token"] ) == md5 ( $token )) {
		return TRUE;
	}
	return FALSE;
}

/**
 * 获取TOKEN
 * 
 * @return string|unknown
 */
function pmx_get_token() {
	if (! isset ( $_SESSION ['pmx_token'] )) {
		return "";
	}
	return $_SESSION ['pmx_token'];
}

/**
 * 登出
 */
function pmx_logout() {
	session_unset ();
	session_destroy ();
}