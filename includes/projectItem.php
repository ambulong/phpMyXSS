<?php
/**
 * 获取项目记录列表
 * @param string $pid
 * @param string $all
 * @return multitype:
 */
function get_item_list($pid = NULL, $all = FALSE) {
	$per_page = 20;
	$offset = $per_page * (get_item_current_page () - 1);
	if ($all == FALSE)
		return (new pmxProjectItems ( $pid ))->getItemList ( $pid, $offset, 20 );
	else
		return (new pmxProjectItems ( $pid ))->getItemdList ( $pid );
}

/**
 * 项目记录ID是否存在
 * 
 * @param unknown $pid        	
 * @return boolean
 */
function is_item_exist($pid) {
	return (new pmxProject ())->isExistID ( $pid );
}

/**
 * 获取项目记录数量
 * 
 * @param string $pid        	
 * @return unknown
 */
function get_item_num($pid = NULL) {
	if ($pid == NULL)
		$pid = get_item_current_id ();
	return (new pmxProjectItems ( $pid ))->getItemNum ( $pid );
}

/**
 * 获取项目记录列表的当前页
 * 
 * @param string $pid        	
 * @return Ambigous <number, unknown>
 */
function get_item_current_page($pid = NULL) {
	if ($pid == NULL)
		$pid = get_item_current_id ();
	if (! isset ( $_GET ['page'] ) || $_GET ['page'] <= 0)
		$current_page = 1;
	elseif ($_GET ['page'] > get_item_max_page ( $pid ))
		$current_page = get_item_max_page ( $pid );
	else
		$current_page = $_GET ['page'];
	return $current_page;
}

/**
 * 获取项目记录的当前项目ID
 * 
 * @return unknown|number
 */
function get_item_current_id() {
	if (isset ( $_GET ['id'] ))
		return $_GET ['id'];
	else
		return - 1;
}

/**
 * 获取项目记录页的最大页数
 * 
 * @param string $pid        	
 * @return number
 */
function get_item_max_page($pid = NULL) {
	if ($pid == NULL)
		$pid = get_item_current_id ();
	$per_page = 20;
	$item_num = get_item_num ( $pid );
	$max_page = (ceil ( $item_num / $per_page ) != 0) ? ceil ( $item_num / $per_page ) : 1;
	return $max_page;
}

/**
 * 获取当前项目记录页的项目记录数范围
 * 
 * @param string $page        	
 * @param string $pid        	
 * @return string
 */
function get_item_page_item_range($page = NULL, $pid = NULL) {
	if ($pid == NULL)
		$pid = get_item_current_id ();
	if ($page == NULL)
		$page = get_item_current_page ( $pid );
	$per_page = 20;
	$page = ($page <= 0) ? 1 : $page;
	$item_num = get_item_num ( $pid );
	if ($item_num == 0)
		return "Empty";
	$first_item = $per_page * ($page - 1) + 1;
	$last_item = $first_item + $per_page - 1;
	if ($last_item > $item_num)
		$last_item = $item_num;
	return "{$first_item} - {$last_item}";
}

/**
 * 获取项目记录页的上一页地址
 * 
 * @param string $pid        	
 * @return string
 */
function get_item_prevpageurl($pid = NULL) {
	if ($pid == NULL)
		$pid = get_item_current_id ();
	$current_page = get_item_current_page ( $pid );
	if ($current_page == 1)
		return "#";
	return pmx_geturl_projdetail ( $pid, $current_page - 1 );
}

/**
 * 获取项目记录页的下一页地址
 * 
 * @param string $pid        	
 * @return string
 */
function get_item_nextpageurl($pid = NULL) {
	if ($pid == NULL)
		$pid = get_item_current_id ();
	$current_page = get_item_current_page ( $pid );
	$max_page = get_item_max_page ( $pid );
	if ($current_page == $max_page)
		return "#";
	return pmx_geturl_projdetail ( $pid, $current_page + 1 );
}