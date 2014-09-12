<?php

/**
 * 模板头文件
 * @param string $title
 */
function pmx_require_header($title = "") {
	$GLOBALS ['pmx_page_title'] = $title;
	require_once (PMX_ABSPATH . PMX_INC . "view/header.inc.php");
}

/**
 * 模板底部文件
 */
function pmx_require_footer() {
	require_once (PMX_ABSPATH . PMX_INC . "view/footer.inc.php");
}

/**
 * Require nav bar
 * 
 * @param
 *        	Active item class $avtive
 */
function pmx_require_nav($avtive) {
	$GLOBALS ['pmx_nav_active'] = $avtive;
	require_once (PMX_ABSPATH . PMX_INC . "view/nav.inc.php");
}

/**
 * 获得页面标题
 * 
 * @return unknown
 */
function pmx_get_title() {
	global $pmx_page_title;
	return $pmx_page_title;
}

/**
 * 获得左导航激活项类
 * 
 * @return unknown
 */
function pmx_get_navactive() {
	global $pmx_nav_active;
	return $pmx_nav_active;
}