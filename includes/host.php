<?php
/**
 * 获取主机列表
 * @param string $status
 * @param string $pid
 * @param string $device
 * @return multitype:
 */
function get_host_list($status = NULL, $pid = NULL, $device = NULL) {
	$per_page = 24;
	$page = get_host_current_page ();
	$offset = $per_page * ($page - 1);
	$row = 24;
	if ($status == NULL)
		$status = isset ( $_GET ["status"] ) ? $_GET ["status"] : "'%'";
	if ($pid == NULL)
		$pid = isset ( $_GET ["pid"] ) ? $_GET ["pid"] : "'%'";
	if ($device == NULL)
		$device = isset ( $_GET ["device"] ) ? $_GET ["device"] : "'%'";
	return (new pmxHosts ())->getHostList ( $offset, $row, $status, $pid, $device );
}

/**
 * 获得有主机项目ID列表
 * 
 * @return multitype:
 */
function get_host_projs() {
	return (new pmxHosts ())->getProjs ();
}

/**
 * 获得主机数量
 * 
 * @param string $status        	
 * @param string $pid        	
 * @param string $device        	
 * @return number
 */
function get_host_num($status = NULL, $pid = NULL, $device = NULL) {
	if ($status == NULL)
		$status = isset ( $_GET ["status"] ) ? $_GET ["status"] : "'%'";
	if ($pid == NULL)
		$pid = isset ( $_GET ["pid"] ) ? $_GET ["pid"] : "'%'";
	if ($device == NULL)
		$device = isset ( $_GET ["device"] ) ? $_GET ["device"] : "'%'";
	return (new pmxHosts ())->getHostNum ( $status, $pid, $device );
}

/**
 * 获取主机页当前页
 * 
 * @return Ambigous <number, unknown>
 */
function get_host_current_page() {
	if (! isset ( $_GET ['page'] ) || $_GET ['page'] <= 0)
		$current_page = 1;
	elseif ($_GET ['page'] > get_host_max_page ())
		$current_page = get_host_max_page ();
	else
		$current_page = $_GET ['page'];
	return $current_page;
}

/**
 * 获取主机页最大页
 * 
 * @return number
 */
function get_host_max_page() {
	$per_page = 24;
	$item_num = get_host_num ();
	$max_page = (ceil ( $item_num / $per_page ) != 0) ? ceil ( $item_num / $per_page ) : 1;
	return $max_page;
}

/**
 * 获取当前页的主机数量范围
 * 
 * @param string $page        	
 * @return string
 */
function get_host_page_range($page = NULL) {
	if ($page == NULL)
		$page = get_host_current_page ();
	$per_page = 24;
	$page = ($page <= 0) ? 1 : $page;
	$item_num = get_host_num ();
	if ($item_num == 0)
		return "Empty";
	$first_item = $per_page * ($page - 1) + 1;
	$last_item = $first_item + $per_page - 1;
	if ($last_item > $item_num)
		$last_item = $item_num;
	return "{$first_item} - {$last_item}";
}

/**
 * 获取主机页上一页地址
 * 
 * @return string
 */
function get_host_prevpageurl() {
	$current_page = get_host_current_page ();
	if ($current_page == 1)
		return "#";
	return pmx_geturl_hostlist ( $current_page - 1 );
}

/**
 * 获取主机页下一页地址
 * 
 * @return string
 */
function get_host_nextpageurl() {
	$current_page = get_host_current_page ();
	$max_page = get_host_max_page ();
	if ($current_page == $max_page)
		return "#";
	return pmx_geturl_hostlist ( $current_page + 1 );
}

/**
 * 查询IP地址的位置
 * 
 * @param unknown $ip        	
 */
function get_host_location($ip) {
	$data = file_get_contents ( "http://freegeoip.net/json/{$ip}" );
	if (! is_json ( $data )) {
		return "";
	}
	$data = json_decode ( $data );
	return $data;
}

/**
 * 获取主机某分类地址
 * 
 * @param unknown $cat        	
 * @return Ambigous <string, mixed>
 */
function get_host_caturl($name, $value) {
	$url = get_url ();
	$var = "&{$name}={$value}";
	
	/**
	 * 是否有同名的其它参数在URL里
	 */
	if (strpos ( $url, "&{$name}=" )) {
		$url = preg_replace ( "/(&" . addslashes ( $name ) . "=\w+)/i", "", $url );
	}
	
	/**
	 * 判断本身是否在URL里面
	 */
	if (! strpos ( get_url (), $var )) {
		$url = $url . $var;
	}
	
	return $url;
}
function host_get_system($userAgent) {
	if ($userAgent == "")
		return "unknow";
	$userAgent = strtolower ( $userAgent );
	if (strpos ( $userAgent, "blackberry" ))
		return "blackberry";
	elseif (strpos ( $userAgent, "android" ))
		return "android";
	elseif (strpos ( $userAgent, "iphone" ))
		return "ios";
	elseif (strpos ( $userAgent, "ipad" ))
		return "ios";
	elseif (strpos ( $userAgent, "linux" ))
		return "linux";
	elseif (strpos ( $userAgent, "mac os" ) || strpos ( $userAgent, "macos" ) || strpos ( $userAgent, "macintosh" ) || strpos ( $userAgent, "mac_powerpc" ))
		return "mac";
	elseif (strpos ( $userAgent, "windows" ) || strpos ( $userAgent, "win98" ) || strpos ( $userAgent, "win16" ) || strpos ( $userAgent, "winnt" ))
		return "windows";
	else
		return "unknow";
}
function host_get_browser($userAgent) {
	if ($userAgent == "")
		return "unknow";
	$userAgent = strtolower ( $userAgent );
	if (strpos ( $userAgent, "msie" ))
		return "ie";
	elseif (strpos ( $userAgent, "firefox" ))
		return "firefox";
	elseif (strpos ( $userAgent, "chrome" ))
		return "chrome";
	elseif (strpos ( $userAgent, "safari" ))
		return "safari";
	elseif (strpos ( $userAgent, "opera" ))
		return "opera";
	else
		return "unknow";
}