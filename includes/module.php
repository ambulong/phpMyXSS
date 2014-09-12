<?php
/**
 * 获取模块列表
 * @param string $cat
 * @param string $all
 * @return multitype:
 */
function get_module_list($cat = NULL, $all = FALSE) {
	$per_page = 15;
	$offset = $per_page * (get_mod_current_page () - 1);
	if ($cat == NULL)
		$cat = get_module_filter_cat ();
	if ($all == FALSE)
		return (new pmxModules ())->getModList ( $cat, $offset, 15 );
	else
		return (new pmxModules ())->getModList ( $cat );
}

/**
 * 获取模块数量
 * 
 * @param string $cat        	
 * @return number
 */
function get_module_num($cat = NULL) {
	if ($cat == NULL)
		$cat = get_module_filter_cat ();
	return (new pmxModules ())->getModNum ( $cat );
}

/**
 * 获取模块分类
 * 
 * @return Ambigous <NULL, unknown>
 */
function get_module_filter_cat() {
	$cat = isset ( $_GET ['cat'] ) ? $_GET ['cat'] : NULL;
	return $cat;
}

/**
 * 获取模块页当前页
 * 
 * @return Ambigous <number, unknown>
 */
function get_mod_current_page() {
	if (! isset ( $_GET ['page'] ) || $_GET ['page'] <= 0)
		$current_page = 1;
	elseif ($_GET ['page'] > get_mod_max_page ())
		$current_page = get_mod_max_page ();
	else
		$current_page = $_GET ['page'];
	return $current_page;
}

/**
 * 获取模块页最大页
 * 
 * @return number
 */
function get_mod_max_page() {
	$per_page = 15;
	$item_num = get_module_num ();
	$max_page = (ceil ( $item_num / $per_page ) != 0) ? ceil ( $item_num / $per_page ) : 1;
	return $max_page;
}

/**
 * 获取当前页的模块数量范围
 * 
 * @param string $page        	
 * @return string
 */
function get_mod_page_item_range($page = NULL) {
	if ($page == NULL)
		$page = get_mod_current_page ();
	$per_page = 15;
	$page = ($page <= 0) ? 1 : $page;
	$item_num = get_module_num ();
	if ($item_num == 0)
		return "Empty";
	$first_item = $per_page * ($page - 1) + 1;
	$last_item = $first_item + $per_page - 1;
	if ($last_item > $item_num)
		$last_item = $item_num;
	return "{$first_item} - {$last_item}";
}

/**
 * 获取模块页上一页地址
 * 
 * @return string
 */
function get_mod_prevpageurl() {
	$current_page = get_mod_current_page ();
	if ($current_page == 1)
		return "#";
	return pmx_geturl_modlist ( $current_page - 1 );
}

/**
 * 获取模块页下一页地址
 * 
 * @return string
 */
function get_mod_nextpageurl() {
	$current_page = get_mod_current_page ();
	$max_page = get_mod_max_page ();
	if ($current_page == $max_page)
		return "#";
	return pmx_geturl_modlist ( $current_page + 1 );
}

/**
 * 获取模块某分类地址
 * 
 * @param unknown $cat        	
 * @return Ambigous <string, mixed>
 */
function get_mod_caturl($cat) {
	$cat = strtoupper ( $cat );
	$url = get_url ();
	$var = "&cat[]=" . $cat;
	if (strpos ( $url, $var )) {
		$url = str_replace ( $var, "", $url );
	} else {
		$url = $url . $var;
	}
	return $url;
}