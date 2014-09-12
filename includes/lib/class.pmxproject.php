<?php
/**
 * 项目操作类
 * @author ambulong
 *
 */
class pmxProject {
	private $dbh = NULL;
	private $id = NULL;
	private $saltid = NULL;
	private $name = NULL;
	private $desc = NULL;
	private $status = 0;
	private $protection = 0;
	private $mail_alert = 0;
	private $mail = NULL;
	private $comments = NULL;
	private $mods = NULL;
	private $mod_config = array ();
	
	/**
	 * 项目信息导入
	 * 
	 * @param string $name        	
	 * @param string $desc        	
	 * @param number $status        	
	 * @param number $protection        	
	 * @param number $mail_alert        	
	 * @param string $mail        	
	 * @param string $comments        	
	 * @param string $mods        	
	 * @param unknown $mod_config        	
	 */
	public function __construct($name = NULL, $desc = NULL, $status = 0, $protection = 0, $mail_alert = 0, $mail = NULL, $comments = NULL, $mods = NULL, $mod_config = array()) {
		$this->dbh = $GLOBALS ['pmx_dbh'];
		
		/**
		 * 生成字符串ID
		 */
		$this->saltid = $this->newSaltID ( 8 );
		while ( $this->isExistSaltID ( $this->saltid ) ) {
			// var_dump($this->isExistSaltID($this->saltid));
			$this->saltid = $this->newSaltID ( 8 );
		}
		
		$this->name = trim ( $name );
		$this->desc = trim ( $desc );
		$this->status = intval ( $status );
		$this->protection = intval ( $protection );
		$this->mail_alert = intval ( $mail_alert );
		$this->mail = trim ( $mail );
		$this->comments = trim ( $comments );
		$this->mods = is_array ( $mods ) ? $mods : array ();
		$this->mod_config = is_array ( $mod_config ) ? $mod_config : array ();
	}
	
	/**
	 * 项目ID是否存在
	 * 
	 * @param int $id        	
	 * @return boolean
	 */
	public function isExistID($id) {
		$id = intval ( $id );
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}projects WHERE `id` = :id " );
			$sth->bindParam ( ':id', $id );
			$sth->execute ();
			$row = $sth->fetch ();
			if ($row [0] > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 项目字符串ID是否存在
	 * 
	 * @param String $saltid
	 *        	要查询的字符串ID
	 * @return boolean
	 */
	public function isExistSaltID($saltid) {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}projects WHERE `saltid` = :saltid" );
			$sth->bindParam ( ':saltid', $saltid );
			$sth->execute ();
			$row = $sth->fetch ();
			if ($row [0] > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 项目名是否存在
	 * 
	 * @param String $name
	 *        	要查询的项目名
	 * @return boolean
	 */
	public function isExistName($name) {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}projects WHERE `name` = :name " );
			$sth->bindParam ( ':name', $name );
			$sth->execute ();
			$row = $sth->fetch ();
			if ($row [0] > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 生成随机字符串
	 * 
	 * @param int $length
	 *        	要生成的字符串长度
	 * @return string
	 */
	public function newSaltID($length = 8) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$salt = '';
		for($i = 0; $i < $length; $i ++) {
			$salt .= $chars [mt_rand ( 0, strlen ( $chars ) - 1 )];
		}
		return $salt;
	}
	
	/**
	 * 获取添加后的项目ID
	 * 
	 * @return boolean
	 */
	public function getID() {
		if ($this->id != NULL)
			return $this->id;
		else
			return FALSE;
	}
	
	/**
	 * 用字符串ID获取项目ID
	 * 
	 * @param string $saltid
	 *        	字符串ID
	 * @return number|unknown
	 */
	public function getIDbySlatID($saltid = "") {
		global $table_prefix;
		if (! $this->isExistSaltID ( $saltid ))
			return - 1;
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}projects WHERE `saltid` = :saltid " );
			$sth->bindParam ( ':saltid', $saltid );
			$sth->execute ();
			$result = $sth->fetch ( PDO::FETCH_ASSOC );
			return $result ['id'];
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 显示添加后的项目ID
	 * 
	 * @return boolean
	 */
	public function showID() {
		if ($this->id != NULL)
			echo $this->id;
		else
			return FALSE;
	}
	
	/**
	 * 添加项目
	 * 
	 * @return boolean
	 */
	public function addProj() {
		global $table_prefix;
		$mods = json_encode ( $this->mods );
		$mod_config = json_encode ( $this->mod_config );
		$addInfo = json_encode ( get_user_info () );
		$lastEditInfo = "";
		if ($this->isExistName ( $this->name )) {
			return FALSE;
		}
		if ($this->isExistSaltID ( $this->saltid )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "INSERT INTO {$table_prefix}projects(`saltid`,`name`,`desc`,`status`,`protection`,`mailAlert`,`mail`,`comments`,`mods`,`modConfig`,`addInfo`,`lastEditInfo`) VALUES(:saltid, :name, :desc, :status, :protection, :mailAlert, :mail, :comments, :mods, :modConfig, :addInfo, :lastEditInfo)" );
			$sth->bindParam ( ':saltid', $this->saltid );
			$sth->bindParam ( ':name', $this->name );
			$sth->bindParam ( ':desc', $this->desc );
			$sth->bindParam ( ':status', $this->status );
			$sth->bindParam ( ':protection', $this->protection );
			$sth->bindParam ( ':mailAlert', $this->mail_alert );
			$sth->bindParam ( ':mail', $this->mail );
			$sth->bindParam ( ':comments', $this->comments );
			$sth->bindParam ( ':mods', $mods );
			$sth->bindParam ( ':modConfig', $mod_config );
			$sth->bindParam ( ':addInfo', $addInfo );
			$sth->bindParam ( ':lastEditInfo', $lastEditInfo );
			$sth->execute ();
			if (! ($sth->rowCount () > 0)) {
				return FALSE;
			}
			$this->id = $this->dbh->lastInsertId ();
			return TRUE;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 更新项目
	 * 
	 * @param int $id
	 *        	项目ID
	 * @return boolean
	 */
	public function updateProj($id) {
		global $table_prefix;
		$id = intval ( $id );
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		$mods = json_encode ( $this->mods );
		$mod_config = json_encode ( $this->mod_config );
		$lastEditInfo = json_encode ( get_user_info () );
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}projects SET `name`= :name,`desc` =  :desc,`status` =  :status,`protection` = :protection,`mailAlert` =  :mailAlert,`mail` = :mail,`comments` =  :comments,`mods` = :mods,`modConfig` = :modConfig ,`lastEditInfo` = :lastEditInfo  WHERE `id` = :id" );
			$sth->bindParam ( ':name', $this->name );
			$sth->bindParam ( ':desc', $this->desc );
			$sth->bindParam ( ':status', $this->status );
			$sth->bindParam ( ':protection', $this->protection );
			$sth->bindParam ( ':mailAlert', $this->mail_alert );
			$sth->bindParam ( ':mail', $this->mail );
			$sth->bindParam ( ':comments', $this->comments );
			$sth->bindParam ( ':mods', $mods );
			$sth->bindParam ( ':modConfig', $mod_config );
			$sth->bindParam ( ':lastEditInfo', $lastEditInfo );
			$sth->bindParam ( ':id', $id );
			$sth->execute ();
			if (! ($sth->rowCount () > 0))
				return FALSE;
			else
				return TRUE;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 删除项目
	 * 
	 * @param int $id
	 *        	项目ID
	 * @return boolean|unknown
	 */
	public function delProj($id) {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}projects WHERE `id` = :id " );
			$sth->bindParam ( ':id', $id );
			$sth->execute ();
			$row = $sth->rowCount ();
			$this->emptyProjItem ( $id );
			/**
			 * 清空项目下的记录
			 */
			if ($row > 0) {
				return $row;
			} else {
				return FALSE;
			}
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 清空项目下的记录
	 * 
	 * @param int $id
	 *        	项目ID
	 * @return boolean|unknown
	 */
	public function emptyProjItem($id) {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}projItems WHERE `pid` = :id " );
			$sth->bindParam ( ':id', $id );
			$sth->execute ();
			$row = $sth->rowCount ();
			if ($row > 0) {
				return $row;
			} else {
				return FALSE;
			}
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 停止项目
	 * 
	 * @param int $id
	 *        	项目ID
	 * @return boolean|unknown
	 */
	public function stopProj($id) {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}projects SET `status` = 0 WHERE `id` = :id " );
			$sth->bindParam ( ':id', $id );
			$sth->execute ();
			$row = $sth->rowCount ();
			if ($row > 0) {
				return $row;
			} else {
				return FALSE;
			}
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 启动项目
	 * 
	 * @param int $id
	 *        	项目ID
	 * @return boolean|unknown
	 */
	public function startProj($id) {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}projects SET `status` = 1 WHERE `id` = :id " );
			$sth->bindParam ( ':id', $id );
			$sth->execute ();
			$row = $sth->rowCount ();
			if ($row > 0) {
				return $row;
			} else {
				return FALSE;
			}
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取项目详细内容
	 * 
	 * @param Int $id
	 *        	项目ID
	 * @return boolean|unknown
	 */
	public function getDetail($id) {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}projects WHERE `id` = :id " );
			$sth->bindParam ( ':id', $id );
			$sth->execute ();
			$result = $sth->fetch ( PDO::FETCH_ASSOC );
			return $result;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取项目下记录的数量
	 * 
	 * @param int $id
	 *        	项目ID
	 * @return boolean|unknown
	 */
	public function getItemNum($id) {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}projItems WHERE `pid` = :id" );
			$sth->bindParam ( ':id', $id );
			$sth->execute ();
			$row = $sth->fetch ();
			return $row [0];
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取项目JS代码
	 * 
	 * @param unknown $id        	
	 * @param string $type
	 *        	nomal为js.php, hook为hook.js, 这会让{pmx.system.projurl}的值不一样
	 * @return boolean|string
	 */
	public function getCode($id, $type = "normal", $urlext = "") {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		$detail = $this->getDetail ( $id );
		$saltid = $detail ['saltid'];
		
		/**
		 * 获取模块ID
		 */
		$mods = json_decode ( $detail ["mods"] );
		
		/**
		 * 获取项目的模块参数配置
		 */
		$projModConfig = json_decode ( $detail ["modConfig"] );
		
		if (count ( $mods ) <= 0)
			return FALSE;
		
		$pmxMod = new pmxModule ();
		$jscode = "";
		
		/**
		 * 把模块参数配置整合到原始模块代码里
		 */
		foreach ( $mods as $modid ) { // BUGS
			if ($pmxMod->isExistID ( $modid )) {
				$code = $pmxMod->getDetail ( $modid )['code'];
				$config = $pmxMod->getConfig ( $modid );
				// echo "\n=============\n$modid";
				// var_dump($config);
				$search = array ();
				if (count ( $config ) > 0) {
					foreach ( $config as $config_item ) {
						$search_item ["search"] = "{pmx.define." . $config_item [0] . "}";
						if (count ( $projModConfig ) > 0) {
							foreach ( $projModConfig as $modConfig_item ) {
								if ($modConfig_item [0] == $modid) {
									if ($modConfig_item [1] == $config_item [0]) {
										$search_item ["replace"] = $modConfig_item [2];
										break;
									} else {
										$search_item ["replace"] = "";
									}
								}
							}
						} else {
							$search_item ["replace"] = "";
						}
						$search [] = $search_item;
						// var_dump($search_item);
					}
				}
				$search [] = array (
						"search" => "{pmx.system.projid}",
						"replace" => $saltid 
				);
				if ($type != "hook") {
					$search [] = array (
							"search" => "{pmx.system.projurl}",
							"replace" => (new pmxURL ())->get_request_puburl ( $saltid ) 
					);
				} else {
					$search [] = array (
							"search" => "{pmx.system.projurl}",
							"replace" => (new pmxURL ())->get_response_puburl ( $saltid, $urlext ) 
					);
				}
				
				/**
				 * 为主机记录生成SID
				 */
				$sid = $this->newSaltID ( 50 );
				while ( (new pmxHost ())->isExistSaltID ( $sid ) ) {
					$sid = $this->newSaltID ( 50 );
				}
				$search [] = array (
						"search" => "{pmx.system.hookurl}",
						"replace" => (new pmxURL ())->get_hook_puburl ( $saltid, $sid . "/" ) 
				);
				// echo $modid." : ";
				// var_dump($search);
				if (count ( $search ) > 0) {
					foreach ( $search as $search_item ) {
						if (trim ( $search_item ["search"] ) != "" && trim ( $code ) != "") {
							$code = str_replace ( $search_item ["search"], $search_item ["replace"], $code );
							// echo "\n===============\n{$modid}*str_replace(".$search_item["search"].", ".$search_item["replace"].', $code);'."\t\n".$code;
						}
					}
				}
				$jscode = $jscode . $code . "\n";
			}
		}
		return $jscode;
	}
	
	/**
	 * 获取项目的模块参数配置
	 * 
	 * @param int $id
	 *        	项目ID
	 * @return boolean|mixed
	 */
	public function getConfig($id) {
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		$detail = $this->getDetail ( $id );
		$config = json_decode ( $detail ["modConfig"], true );
		return $config;
	}
}