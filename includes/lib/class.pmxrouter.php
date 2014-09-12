<?php
/**
 * 程序路由处理类
 * @author ambulong
 *
 */
class pmxRouter {
	private $URI = NULL;
	private $MODULE = array (
			"view",
			"action",
			"api" 
	);
	private $FILE = array (
			"main",
			"login",
			"project-list",
			"host-list",
			"module-list",
			"add-project",
			"add-module",
			"delete-project",
			"delete-module",
			"edit-project",
			"edit-module",
			"save-project",
			"save-module",
			"project",
			"host",
			"module",
			"project-item",
			"info",
			"logout",
			"setting",
			"search",
			"module-config",
			"start-project",
			"stop-project",
			"delete-item",
			"delete-host-ip",
			"delete-host-sid",
			"delete-offline-host",
			"delete-hostlog-sid",
			"get-logs",
			"add-command" 
	);
	
	/**
	 * 获取并简单处理URL
	 */
	public function __construct() {
		$current_url = strtolower ( get_url () );
		$this->URI = substr ( $current_url, strlen ( PMX_SITEURL ), strlen ( $current_url ) - strlen ( PMX_SITEURL ) );
	}
	
	/**
	 * 初始化路由
	 */
	public function init() {
		$uri = explode ( '/', $this->URI );
		
		// validate uri
		if (! in_array ( $uri [2], $this->MODULE )) {
			pmx_gourl_home ();
			exit ();
		}
		$module = (count ( $uri ) > 2) ? $uri [2] : "view";
		$file = (count ( $uri ) > 3) ? $uri [3] : "main";
		
		$module = (in_array ( $module, $this->MODULE )) ? $module : "view";
		$file = (in_array ( $file, $this->FILE )) ? $file : "main";
		$filename = PMX_ABSPATH . PMX_INC . $module . "/" . $file . ".php";
		if (is_readable ( $filename )) {
			require_once (PMX_ABSPATH . PMX_INC . "authControl.php");
			require_once ($filename);
		} else {
			header ( 'Content-Type: text/plain; charset=utf-8' );
			die ( "ERROR: File  ./" . PMX_INC . $module . "/" . $file . ".php" . " is unreadable." );
		}
	}
}
