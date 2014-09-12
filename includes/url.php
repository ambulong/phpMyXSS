<?php

/**
 * 跳转到登录页
 */
function pmx_gourl_login() {
	header ( "location:" . (new pmxURL ())->get_login_url () );
}

/**
 * 跳转到主页
 */
function pmx_gourl_home() {
	header ( "location:" . (new pmxURL ())->get_home_url () );
}

/**
 * 跳转到项目列表页
 */
function pmx_gourl_projlist() {
	header ( "location:" . (new pmxURL ())->get_projlist_url () );
}

/**
 * 获得网站地址
 * 
 * @return string
 */
function pmx_geturl_site() {
	return (new pmxURL ())->get_site_url ();
}

/**
 * 获得网站主页
 * 
 * @return string
 */
function pmx_geturl_home() {
	return (new pmxURL ())->get_home_url ();
}

/**
 * 获得登录地址
 * 
 * @return string
 */
function pmx_geturl_login() {
	return (new pmxURL ())->get_login_url ();
}

/**
 * 获得项目列表地址
 * 
 * @param number $page        	
 * @return string
 */
function pmx_geturl_projlist($page = 1) {
	return (new pmxURL ())->get_projlist_url ( $page );
}

/**
 * 获得主机列表地址
 * 
 * @param number $page        	
 * @param string $filter        	
 * @return string
 */
function pmx_geturl_hostlist($page = 1, $filter = NULL) {
	return (new pmxURL ())->get_hostlist_url ( $page, $filter );
}

/**
 * 获得模块列表地址
 * 
 * @param number $page        	
 * @param string $filter        	
 * @return string
 */
function pmx_geturl_modlist($page = 1, $filter = NULL) {
	return (new pmxURL ())->get_modlist_url ( $page, $filter );
}

/**
 * 获得添加项目页地址
 * 
 * @return string
 */
function pmx_geturl_addproj() {
	return (new pmxURL ())->get_addproj_url ();
}

/**
 * 获得添加模块页地址
 * 
 * @return string
 *
 */
function pmx_geturl_addmod() {
	return (new pmxURL ())->get_addmod_url ();
}

/**
 * 获得编辑项目页地址
 * 
 * @return string
 */
function pmx_geturl_editproj($id) {
	return (new pmxURL ())->get_editproj_url ( $id );
}

/**
 * 获得编辑模块页地址
 * 
 * @return string
 */
function pmx_geturl_editmod($id) {
	return (new pmxURL ())->get_editmod_url ( $id );
}

/**
 * 获得静态文件页地址
 * 
 * @return string
 */
function pmx_geturl_staticfile() {
	return (new pmxURL ())->get_staticfile_url ();
}

/**
 * 获得项目记录列表页地址
 * 
 * @return string
 */
function pmx_geturl_projdetail($id, $page = 1) {
	return (new pmxURL ())->get_projdetail_url ( $id, $page );
}

/**
 * 获得主机操作页地址
 * 
 * @return string
 */
function pmx_geturl_hostdetail($id) {
	return (new pmxURL ())->get_hostdetail_url ( $id );
}

/**
 * 获得模块详情页地址
 * 
 * @return string
 */
function pmx_geturl_moddetail($id) {
	return (new pmxURL ())->get_moddetail_url ( $id );
}

/**
 * 获得项目记录详情页地址
 * 
 * @return string
 */
function pmx_geturl_itemdetail($id) {
	return (new pmxURL ())->get_itemdetail_url ( $id );
}

/**
 * 获得网站设置页地址
 * 
 * @return string
 */
function pmx_geturl_setting() {
	return (new pmxURL ())->get_setting_url ();
}

/**
 * 获得登出地址
 * 
 * @return string
 */
function pmx_geturl_logout() {
	return (new pmxURL ())->get_logout_url ();
}

/**
 * 获得登录模块地址
 * 
 * @return string
 */
function pmx_getactionurl_login() {
	return (new pmxURL ())->get_login_actionurl ();
}

/**
 * 获得登出模块地址
 * 
 * @return string
 */
function pmx_getactionurl_logout() {
	return (new pmxURL ())->get_logout_actionurl ();
}

/**
 * 获得搜索模块地址
 * 
 * @return string
 */
function pmx_getactionurl_search() {
	return (new pmxURL ())->get_search_actionurl ();
}

/**
 * 获得添加模块模块地址
 * 
 * @return string
 */
function pmx_getactionurl_addmod() {
	return (new pmxURL ())->get_addmod_actionurl ();
}

/**
 * 获得删除模块模块地址
 * 
 * @param unknown $id        	
 * @return string
 */
function pmx_getactionurl_delmod($id) {
	return (new pmxURL ())->get_delmod_actionurl ( $id );
}

/**
 * 获得保存模块模块地址
 * 
 * @return string
 */
function pmx_getactionurl_savemod() {
	return (new pmxURL ())->get_savemod_actionurl ();
}

/**
 * 获得添加项目模块地址
 * 
 * @return string
 */
function pmx_getactionurl_addproj() {
	return (new pmxURL ())->get_addproj_actionurl ();
}

/**
 * 获得删除项目模块地址
 * 
 * @param unknown $id        	
 * @return string
 */
function pmx_getactionurl_delproj($id) {
	return (new pmxURL ())->get_delproj_actionurl ( $id );
}

/**
 * 获得保存项目模块地址
 * 
 * @return string
 */
function pmx_getactionurl_saveproj() {
	return (new pmxURL ())->get_saveproj_actionurl ();
}

/**
 * 获得停止项目模块地址
 * 
 * @param unknown $id        	
 * @return string
 */
function pmx_getactionurl_stopproj($id) {
	return (new pmxURL ())->get_stopproj_actionurl ( $id );
}

/**
 * 获得启动项目模块地址
 * 
 * @param unknown $id        	
 * @return string
 */
function pmx_getactionurl_startproj($id) {
	return (new pmxURL ())->get_startproj_actionurl ( $id );
}

/**
 * 获得删除项目记录模块地址
 * 
 * @param unknown $id        	
 * @return string
 */
function pmx_getactionurl_delitem($id) {
	return (new pmxURL ())->get_delitem_actionurl ( $id );
}

/**
 * 获得删除主机模块地址(IP)
 * 
 * @param unknown $ip        	
 * @return string
 */
function pmx_getactionurl_delHost($ip) {
	return (new pmxURL ())->get_delhostip_actionurl ( $ip );
}

/**
 * 获得删除主机模块地址(sid)
 * 
 * @param unknown $sid        	
 * @return string
 */
function pmx_getactionurl_delHostSID($sid) {
	return (new pmxURL ())->get_delhostsid_actionurl ( $sid );
}

/**
 * 获得删除不在线主机模块地址
 * 
 * @return string
 */
function pmx_getactionurl_delOfflineHost() {
	return (new pmxURL ())->get_delofflinehost_actionurl ();
}

/**
 * 获得删除主机记录模块地址
 * 
 * @param unknown $sid        	
 * @return string
 */
function pmx_getactionurl_delHostLogSID($sid) {
	return (new pmxURL ())->get_delhostlogsid_actionurl ( $sid );
}

/**
 * 获取模块详情API地址
 * 
 * @param unknown $id        	
 * @return string
 */
function pmx_getapiurl_moddetail($id) {
	return (new pmxURL ())->get_moddetail_apiurl ( $id );
}

/**
 * 获取模块配置API地址
 * 
 * @param unknown $id        	
 * @return string
 */
function pmx_getapiurl_modconfig($id) {
	return (new pmxURL ())->get_modconfig_apiurl ( $id );
}

/**
 * 获取公开地址（JS代码地址）
 * 
 * @param unknown $saltid        	
 * @return string
 */
function pmx_getpuburl_projcode($saltid) {
	return (new pmxURL ())->get_projcode_puburl ( $saltid );
}

/**
 * 获取公开地址（数据接收地址）
 * 
 * @param unknown $saltid        	
 * @return string
 */
function pmx_getpuburl_request($saltid) {
	return (new pmxURL ())->get_request_puburl ( $saltid );
}