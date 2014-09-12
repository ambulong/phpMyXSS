<?php
/**
 * 模块操作类
 * @author ambulong
 *
 */
class pmxModule {
	private $dbh = NULL;
	private $id = NULL;
	private $name = NULL;
	private $desc = NULL;
	private $cat = 2;
	private $only = 0;
	private $code = NULL;
	
	/**
	 * 模块信息导入
	 * 
	 * @param string $name        	
	 * @param string $desc        	
	 * @param number $cat        	
	 * @param number $only        	
	 * @param string $code        	
	 */
	public function __construct($name = NULL, $desc = NULL, $cat = 2, $only = 0, $code = NULL) {
		$this->dbh = $GLOBALS ['pmx_dbh']; // 获取全局数据库连接句柄
		$this->name = trim ( $name );
		$this->desc = trim ( $desc );
		$this->cat = intval ( $cat );
		$this->only = intval ( $only );
		$this->code = $code;
	}
	
	/**
	 * 是否存在模块ID
	 * 
	 * @param number $id
	 *        	要查询的ID
	 * @return boolean
	 */
	public function isExistID($id) {
		$id = intval ( $id );
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}modules WHERE `id` = :id " );
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
	 * 是否存在模块名
	 * 
	 * @param String $name
	 *        	要查询的模块名
	 * @return boolean
	 */
	public function isExistName($name) {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}modules WHERE `name` = :name " );
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
	 * 添加模块
	 * 
	 * @return boolean
	 */
	public function addMod() {
		global $table_prefix;
		$addInfo = json_encode ( get_user_info () ); // 添加此模块用户的系统信息
		$lastEditInfo = ""; // 最后编辑此模块用户的系统信息
		
		if ($this->isExistName ( $this->name )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "INSERT INTO {$table_prefix}modules(`name`,`desc`,`cat`,`only`,`code`,`addInfo`,`lastEditInfo`) VALUES( :name, :desc, :cat, :only, :code, :addInfo, :lastEditInfo)" );
			$sth->bindParam ( ':name', $this->name );
			$sth->bindParam ( ':desc', $this->desc );
			$sth->bindParam ( ':cat', $this->cat );
			$sth->bindParam ( ':only', $this->only );
			$sth->bindParam ( ':code', $this->code );
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
	 * 获取模块添加后的ID
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
	 * 输出模块添加后的ID
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
	 * 更新模块内容
	 * 
	 * @param int $id
	 *        	要更新的模块ID
	 * @return boolean
	 */
	public function updateMod($id) {
		global $table_prefix;
		$lastEditInfo = json_encode ( get_user_info () );
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}modules SET `name` = :name,`desc` = :desc,`cat` = :cat,`only`= :only,`code` = :code,`lastEditInfo` = :lastEditInfo WHERE `id` = :id and `editable` = 1 " );
			$sth->bindParam ( ':name', $this->name );
			$sth->bindParam ( ':desc', $this->desc );
			$sth->bindParam ( ':cat', $this->cat );
			$sth->bindParam ( ':only', $this->only );
			$sth->bindParam ( ':code', $this->code );
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
	 * 删除模块
	 * 
	 * @param int $id
	 *        	要删除模块的ID
	 * @return boolean|unknown
	 */
	public function delMod($id) {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}modules WHERE `id` = :id and `deletable` = 1 " );
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
	 * 获取模块的详细内容
	 * 
	 * @param int $id
	 *        	模块的ID
	 * @return boolean|unknown
	 */
	public function getDetail($id) {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}modules WHERE `id` = :id " );
			$sth->bindParam ( ':id', $id );
			$sth->execute ();
			$result = $sth->fetch ( PDO::FETCH_ASSOC );
			return $result;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取模块的配置
	 *
	 * 模块不存在时返回FALSE， 代码为空或者获取不到配置信息返回空数组， 成功则返回配置信息数组 array(参数名， 参数描述)
	 * 
	 * @param int $id
	 *        	模块的ID
	 * @return boolean|multitype:|multitype:multitype:string unknown Ambigous <boolean, multitype:NULL > multitype:string Ambigous <boolean, unknown>
	 */
	public function getConfig($id) {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		$data = $this->getDetail ( $id );
		if (trim ( $data ['code'] ) == "")
			return array ();
		$code = $data ['code'];
		preg_match_all ( "/{\s*pmx.define.(.+)\s*}/i", $code, $matches );
		if (count ( $matches [0] ) <= 0) {
			return array ();
		}
		$descs = array (); // 储存参数描述
		$names = array (); // 储存参数名
		$configs = array (); // 储存整合参数名和参数描述后的数组
		
		/**
		 * 获取参数名和参数描述
		 */
		foreach ( $matches [0] as $value ) {
			if ($this->isDefineConstName ( $value )) { // 是否为参数名
				$names [] = $this->getDefineConstName ( $value );
			} elseif ($this->isDefineConstDesc ( $value )) { // 是否为参数描述
				$descs [] = $this->getDefineConstDesc ( $value );
			}
		}
		/**
		 * 判断模块里是否有参数
		 */
		if (count ( $names ) <= 0) {
			return array ();
		}
		
		/**
		 * 整合参数名和参数描述，防止有参数描述但是没有参数定义的数据
		 */
		foreach ( $names as $name ) {
			if (count ( $descs ) > 0) {
				foreach ( $descs as $desc ) {
					if (in_array ( $name, $desc )) {
						$configs [] = $desc;
					} else {
						$configs [] = array (
								$name,
								"" 
						); // 找不到参数描述，参数描述为空
					}
				}
			} else {
				$configs [] = array (
						$name,
						"" 
				); // 没有关于任何参数描述，参数描述为空
			}
		}
		return $configs;
	}
	
	/**
	 * 此语句是否在定义参数名
	 * 
	 * @param string $str
	 *        	要判断的语句
	 * @return boolean
	 */
	public function isDefineConstName($str) {
		$str_temp = str_replace ( "pmx.define.", "", $str );
		if (strpos ( $str, "\"" ) || strpos ( $str_temp, "." ) || $this->isDefineConstDesc ( $str )) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	/**
	 * 此语句是否在描述参数
	 * 
	 * @param string $str
	 *        	要判断的语句
	 * @return boolean
	 */
	public function isDefineConstDesc($str) {
		if (preg_match ( "/{\s*pmx.define.([a-zA-Z0-9]+).desc\s*,\s*\"(.+)\"\s*}/i", $str )) {
			
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * 获取语句中定义的参数名
	 * 
	 * @param string $str
	 *        	要操作的语句
	 * @return boolean|unknown
	 */
	public function getDefineConstName($str) {
		/**
		 * 先判断是否为定义参数的语句
		 */
		if (! $this->isDefineConstName ( $str )) {
			return FALSE;
		}
		
		if (preg_match ( "/{\s*pmx.define.(.+)\s*}/i", $str, $match ))
			return $match [1];
		else
			return FALSE;
	}
	
	/**
	 * 获取语句中参数和参数描述 array(参数名， 参数描述)
	 * 
	 * @param string $str
	 *        	要操作的语句
	 * @return boolean|multitype:NULL
	 */
	public function getDefineConstDesc($str) {
		if (! $this->isDefineConstDesc ( $str )) {
			return FALSE;
		}
		if (preg_match_all ( "/{\s*pmx.define.([a-zA-Z0-9]+).desc\s*,\s*\"(.+)\"\s*}/i", $str, $match ))
			return array (
					$match [1] [0],
					$match [2] [0] 
			);
		else
			// echo $str;
			return FALSE;
	}
	
	/**
	 * 获取加入配置信息后的代码
	 * 
	 * @param unknown $mid        	
	 * @param unknown $mconfig        	
	 * @return boolean|multitype
	 */
	public function getConfigedCode($mid, $mconfig) {
		$detail = $this->getDetail ( $mid );
		$code = $detail ["code"];
		if (! count ( $mconfig ) > 0)
			return $code;
		foreach ( $mconfig as $mconfig_item ) {
			$code = str_replace ( $mconfig_item ["search"], $mconfig_item ["replace"], $code );
		}
		return $code;
	}
}