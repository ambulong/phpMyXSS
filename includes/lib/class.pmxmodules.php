<?php
/**
 * 模块列表操作类
 * @author ambulong
 *
 */
class pmxModules {
	private $dbh = NULL;
	private $cat = "ALL"; // 默认模块分类
	private $allow_cats = array ( // 允许输入的模块分类
			"ALL", // 全部分类
			"DEFAULT", // 默认模块
			"EXP", // 利用模块
			"CUSTOM"  // 自定义模块
		);
	
	/**
	 * 要查询分类中的模块
	 * 
	 * @param string $cat        	
	 */
	public function __construct($cat = "ALL") {
		$this->dbh = $GLOBALS ["pmx_dbh"];
		if (is_array ( $cat ))
			$cat = array_unique ( $cat );
		$this->cat = $this->validateCat ( $cat );
	}
	
	/**
	 * 校验输入查询分类是否正确
	 * 
	 * @param 要查询的分类 $cat        	
	 * @return unknown|string
	 */
	public function validateCat($cat) {
		if (is_array ( $cat )) {
			if (array_intersect ( $cat, $this->allow_cats ) == $cat) {
				return $cat;
			} else {
				return "ALL";
			}
		} else {
			if (in_array ( $cat, $this->allow_cats ))
				return $cat;
			else
				return "ALL";
		}
	}
	
	/**
	 * 把分类从数组转为分类代号的字符串（在SQL语句里操作）
	 * 
	 * @param string $cat
	 *        	要操作的分类
	 * @return string
	 */
	public function arrayCat2strCat($cat) {
		if (is_array ( $cat )) {
			if (in_array ( "ALL", $cat )) {
				$cat = "0, 1, 2";
			} else {
				$cat = str_replace ( array (
						"DEFAULT",
						"EXP",
						"CUSTOM" 
				), array (
						"0",
						"1",
						"2" 
				), $cat );
				$cat = implode ( ",", $cat );
			}
		} else {
			switch ($cat) {
				case "DEFAULT" :
					$cat = "0";
					break;
				case "EXP" :
					$cat = "1";
					break;
				case "CUSTOM" :
					$cat = "2";
					break;
				default :
					$cat = "0, 1, 2";
			}
		}
		return $cat;
	}
	
	/**
	 * 获取模块信息数组
	 * 
	 * @param string $cat        	
	 * @param number $offset        	
	 * @param string $row        	
	 * @return multitype:
	 */
	public function getModList($cat = NULL, $offset = 0, $row = NULL) {
		global $table_prefix;
		$offset = intval ( $offset );
		$row = intval ( $row );
		if ($cat == NULL) {
			$cat = $this->cat;
		} else {
			$cat = $this->validateCat ( $cat );
		}
		$cat = $this->arrayCat2strCat ( $cat );
		try {
			if ($row == NULL)
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}modules WHERE `cat` IN({$cat})  ORDER BY `id` DESC" );
			else
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}modules WHERE `cat` IN({$cat})  ORDER BY `id` DESC LIMIT {$offset},{$row}" );
			$sth->execute ();
			$result = $sth->fetchAll ( PDO::FETCH_ASSOC );
			if (count ( $result ) <= 0) {
				$result = array ();
			}
			return $result;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取模块数量或者某分类的模块数量
	 * 
	 * @param string $cat        	
	 * @return number
	 */
	public function getModNum($cat = NULL) {
		global $table_prefix;
		if ($cat == NULL) {
			$cat = $this->cat;
		} else {
			$cat = $this->validateCat ( $cat );
		}
		$cat = $this->arrayCat2strCat ( $cat );
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}modules WHERE `cat` IN({$cat})" );
			$sth->execute ();
			$row = $sth->fetch ();
			return $row [0];
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
}