<?php
/**
 * 项目记录列表操作类
 * @author ambulong
 *
 */
class pmxProjectItems {
	private $dbh = NULL;
	public function __construct() {
		$this->dbh = $GLOBALS ["pmx_dbh"];
	}
	
	/**
	 * 指定项目ID，和其它信息
	 * 
	 * @param string $pid        	
	 * @param number $offset        	
	 * @param string $row        	
	 * @return multitype:
	 */
	public function getItemList($pid = NULL, $offset = 0, $row = NULL) {
		global $table_prefix;
		$offset = intval ( $offset );
		$row = intval ( $row );
		try {
			if ($row == NULL)
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}projItems WHERE `pid` = :pid  ORDER BY `id` DESC" );
			else
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}projItems WHERE `pid` = :pid  ORDER BY `id` DESC LIMIT {$offset},{$row}" );
			$sth->bindParam ( ':pid', $pid );
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
	 * 获取项目下记录的数量
	 * 
	 * @param string $pid        	
	 * @return unknown
	 */
	public function getItemNum($pid = NULL) {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}projItems WHERE `pid` = :pid" );
			$sth->bindParam ( ':pid', $pid );
			$sth->execute ();
			$row = $sth->fetch ();
			return $row [0];
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
}