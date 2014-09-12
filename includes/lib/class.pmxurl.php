<?php
/**
 * 获取程序各项操作模块和显示模块的URL
 * @author ambulong
 *
 */
class pmxURL {
	private $SITE = null;
	public function __construct() {
		if (substr ( PMX_SITEURL, strlen ( PMX_SITEURL ) - 1, 1 ) == "/") {
			$this->SITE = substr ( PMX_SITEURL, 0, strlen ( PMX_SITEURL ) - 1 );
		} else {
			$this->SITE = PMX_SITEURL;
		}
	}
	
	/**
	 * 获取网站主页
	 * 
	 * @return string
	 */
	public function get_site_url() {
		return $this->SITE . "/";
	}
	
	/**
	 * 获取网站静态文件存放目录
	 * 
	 * @return string
	 */
	public function get_staticfile_url() {
		return $this->SITE . "/static/";
	}
	
	/**
	 * 获取网站主页
	 * 
	 * @return string
	 */
	public function get_home_url() {
		return $this->SITE . "/index.php/view/main/";
	}
	
	/**
	 * 获取网站登录页
	 * 
	 * @return string
	 */
	public function get_login_url() {
		return $this->SITE . "/index.php/view/login/";
	}
	
	/**
	 * 获取项目列表页
	 * 
	 * @param number $page        	
	 * @return string
	 */
	public function get_projlist_url($page = 1) {
		return $this->SITE . "/index.php/view/project-list/?page={$page}";
	}
	
	/**
	 * 获取主机列表页
	 * 
	 * @param number $page        	
	 * @param string $filter        	
	 * @return string
	 */
	public function get_hostlist_url($page = 1, $filter = NULL) {
		if (substr ( $filter, 0, 1 ) != "&")
			$filter = "&" . $filter;
		return $this->SITE . "/index.php/view/host-list/?page={$page}{$filter}";
	}
	
	/**
	 * 获取模块列表页
	 * 
	 * @param number $page        	
	 * @param string $filter        	
	 * @return string
	 */
	public function get_modlist_url($page = 1, $filter = NULL) {
		if (substr ( $filter, 0, 1 ) != "&")
			$filter = "&" . $filter;
		return $this->SITE . "/index.php/view/module-list/?page={$page}{$filter}";
	}
	
	/**
	 * 获取添加项目页
	 * 
	 * @return string
	 */
	public function get_addproj_url() {
		return $this->SITE . "/index.php/view/add-project/";
	}
	
	/**
	 * 获取添加模块页
	 * 
	 * @return string
	 */
	public function get_addmod_url() {
		return $this->SITE . "/index.php/view/add-module/";
	}
	
	/**
	 * 获取编辑项目页
	 * 
	 * @param unknown $id        	
	 * @return string
	 */
	public function get_editproj_url($id) {
		return $this->SITE . "/index.php/view/edit-project/?id={$id}";
	}
	
	/**
	 * 获取编辑模块页
	 * 
	 * @param unknown $id        	
	 * @return string
	 */
	public function get_editmod_url($id) {
		return $this->SITE . "/index.php/view/edit-module/?id={$id}";
	}
	
	/**
	 * 获取项目记录列表页
	 * 
	 * @param unknown $id        	
	 * @param number $page        	
	 * @return string
	 */
	public function get_projdetail_url($id, $page = 1) {
		return $this->SITE . "/index.php/view/project/?id={$id}&page={$page}";
	}
	
	/**
	 * 获取主机操作页
	 * 
	 * @param unknown $id        	
	 * @return string
	 */
	public function get_hostdetail_url($id) {
		return $this->SITE . "/index.php/view/host/?id={$id}";
	}
	
	/**
	 * 获取模块详细信息页
	 * 
	 * @param unknown $id        	
	 * @return string
	 */
	public function get_moddetail_url($id) {
		return $this->SITE . "/index.php/view/module/?id={$id}";
	}
	
	/**
	 * 获取项目记录详细信息页
	 * 
	 * @param unknown $id        	
	 * @return string
	 */
	public function get_itemdetail_url($id) {
		return $this->SITE . "/index.php/view/project-item/?id={$id}";
	}
	
	/**
	 * 获取网站设置页
	 * 
	 * @return string
	 */
	public function get_setting_url() {
		return $this->SITE . "/index.php/view/setting/";
	}
	
	/**
	 * 获取退出链接
	 * 
	 * @return string
	 */
	public function get_logout_url() {
		return $this->SITE . "/index.php/view/logout/?token=" . $_SESSION ["pmx_token"];
	}
	
	/**
	 * 获取登录处理模块地址
	 * 
	 * @return string
	 */
	public function get_login_actionurl() {
		return $this->SITE . "/index.php/action/login/";
	}
	
	/**
	 * 获取登出处理模块地址
	 * 
	 * @return string
	 */
	public function get_logout_actionurl() {
		return $this->SITE . "/index.php/action/logout/?token=" . $_SESSION ["pmx_token"];
	}
	
	/**
	 * 获取搜索模块地址
	 * 
	 * @return string
	 */
	public function get_search_actionurl() {
		return $this->SITE . "/index.php/action/search/";
	}
	
	/**
	 * 获取添加模块模块地址
	 * 
	 * @return string
	 */
	public function get_addmod_actionurl() {
		return $this->SITE . "/index.php/action/add-module/";
	}
	
	/**
	 * 获取删除模块模块地址
	 * 
	 * @param unknown $id        	
	 * @return string
	 */
	public function get_delmod_actionurl($id) {
		return $this->SITE . "/index.php/action/delete-module/?id={$id}&token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获取保存模块操作模块地址
	 * 
	 * @return string
	 */
	public function get_savemod_actionurl() {
		return $this->SITE . "/index.php/action/save-module/";
	}
	
	/**
	 * 获取添加项目模块地址
	 * 
	 * @return string
	 */
	public function get_addproj_actionurl() {
		return $this->SITE . "/index.php/action/add-project/";
	}
	
	/**
	 * 获取删除项目操作地址
	 * 
	 * @param unknown $id        	
	 * @return string
	 */
	public function get_delproj_actionurl($id) {
		return $this->SITE . "/index.php/action/delete-project/?id={$id}&token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获取保存项目模块地址
	 * 
	 * @return string
	 */
	public function get_saveproj_actionurl() {
		return $this->SITE . "/index.php/action/save-project/";
	}
	
	/**
	 * 获取停止项目模块地址
	 * 
	 * @param unknown $id        	
	 * @return string
	 */
	public function get_stopproj_actionurl($id) {
		return $this->SITE . "/index.php/action/stop-project/?id={$id}&token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获取启动项目模块地址
	 * 
	 * @param unknown $id        	
	 * @return string
	 */
	public function get_startproj_actionurl($id) {
		return $this->SITE . "/index.php/action/start-project/?id={$id}&token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获取删除项目记录模块地址
	 * 
	 * @param unknown $id        	
	 * @return string
	 */
	public function get_delitem_actionurl($id) {
		return $this->SITE . "/index.php/action/delete-item/?id={$id}&token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获得删除主机模块地址(IP)
	 * 
	 * @param unknown $ip        	
	 * @return string
	 */
	public function get_delhostip_actionurl($ip) {
		return $this->SITE . "/index.php/action/delete-host-ip/?ip={$ip}&token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获得删除主机模块地址(sid)
	 * 
	 * @param unknown $sid        	
	 * @return string
	 */
	public function get_delhostsid_actionurl($sid) {
		return $this->SITE . "/index.php/action/delete-host-sid/?sid={$sid}&token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获得删除不在线主机模块地址
	 * 
	 * @return string
	 */
	public function get_delofflinehost_actionurl() {
		return $this->SITE . "/index.php/action/delete-offline-host/?token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获得删除主机记录模块地址
	 * 
	 * @param unknown $sid        	
	 * @return string
	 */
	public function get_delhostlogsid_actionurl($sid) {
		return $this->SITE . "/index.php/action/delete-hostlog-sid/?sid={$sid}&token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获取添加命令模块地址
	 * 
	 * @param unknown $sid        	
	 * @return string
	 */
	public function get_addcommand_actionurl($sid) {
		return $this->SITE . "/index.php/action/add-command/?sid={$sid}&token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获取模块详细内容API地址
	 * 
	 * @param unknown $id        	
	 * @return string
	 */
	public function get_moddetail_apiurl($id) {
		return $this->SITE . "/index.php/api/module/?id={$id}&token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获取模块配置API地址
	 * 
	 * @param unknown $id        	
	 * @return string
	 */
	public function get_modconfig_apiurl($id) {
		return $this->SITE . "/index.php/api/module-config/?id={$id}&token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获取主机记录地址
	 * 
	 * @param unknown $sid        	
	 * @return string
	 */
	public function get_hostlog_apiurl($sid) {
		return $this->SITE . "/index.php/api/get-logs/?sid={$sid}&token=" . $_SESSION ['pmx_token'];
	}
	
	/**
	 * 获取公开地址（JS代码地址）
	 * 
	 * @param unknown $saltid        	
	 * @return string
	 */
	public function get_projcode_puburl($saltid) {
		return $this->SITE . "/js.php/{$saltid}/";
	}
	
	/**
	 * 获取公开地址（数据接收地址）
	 * 
	 * @param unknown $saltid        	
	 * @return string
	 */
	public function get_request_puburl($saltid) {
		return $this->SITE . "/request.php/{$saltid}/";
	}
	
	/**
	 * 获取公开地址（hook指令接收地址）
	 * 
	 * @param unknown $saltid        	
	 * @return string
	 */
	public function get_hook_puburl($saltid, $ext = "") {
		return $this->SITE . "/hook.php/{$saltid}/" . $ext;
	}
	
	/**
	 * 获取公开地址（hook数据接收地址）
	 * 
	 * @param unknown $saltid        	
	 * @return string
	 */
	public function get_response_puburl($saltid, $ext = "") {
		return $this->SITE . "/response.php/{$saltid}/" . $ext;
	}
}