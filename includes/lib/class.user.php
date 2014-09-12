<?php
/**
 * 用户操作类
 * @author ambulong
 *
 */
class USER {
	private $username = NULL;
	private $password = NULL;
	private $hash_verify = NULL;
	private $hasher = NULL;
	private $hash = NULL;
	private $auth = NULL;
	
	/**
	 * 用户信息导入
	 * 
	 * @param string $username        	
	 * @param string $password        	
	 */
	public function __construct($username = NULL, $password = NULL) {
		$this->username = trim ( $username );
		$this->password = trim ( $password );
		$this->hash_verify = PMX_PASSWORD;
		$this->hasher = new PasswordHash ( 8, FALSE );
		$this->hash = $this->hasher->HashPassword ( $password );
		$this->auth = FALSE;
	}
	
	/**
	 * 销毁hash
	 */
	public function __destruct() {
		if (isset ( $this->hasher ))
			unset ( $this->hasher );
	}
	
	/**
	 * 校验帐号密码
	 * 
	 * @return number
	 */
	public function auth() {
		if (strcmp ( $this->username, PMX_USERNAME ) == 0 && ($this->hasher->CheckPassword ( $this->password, $this->hash_verify ))) {
			$this->auth = TRUE;
			return 1;
		} else {
			$this->auth = FALSE;
			return 0;
		}
	}
	
	/**
	 * 登录操作
	 * 
	 * @return number
	 */
	public function login() {
		if ($this->auth == TRUE) {
			$_SESSION ['pmx_user'] = $this->username;
			$_SESSION ['pmx_token'] = md5 ( str_shuffle ( $_SERVER ['REMOTE_ADDR'] . rand () . time () ) );
			return 1;
		} else {
			return 0;
		}
	}
}