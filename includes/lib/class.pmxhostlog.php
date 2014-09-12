<?php
/**
 * 主机记录操作类
 * @author ambulong
 *
 */
class pmxHostLog {
	private $dbh = NULL;
	private $sid = NULL;
	private $id = NULL;
	
	/**
	 * 初始化DBH
	 */
	public function __construct() {
		$this->dbh = $GLOBALS ['pmx_dbh'];
	}
	
	/**
	 * 主机记录ID是否存在
	 * 
	 * @param int $id        	
	 * @return boolean
	 */
	public function isExistID($id) {
		$id = intval ( $id );
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}hostLogs WHERE `id` = :id " );
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
	 * 主机记录字符串ID是否存在
	 * 
	 * @param String $saltid
	 *        	要查询的字符串ID
	 * @return boolean
	 */
	public function isExistSaltID($saltid) {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}hostLogs WHERE `saltid` = :saltid" );
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
	 * 添加命令
	 * 
	 * @param unknown $sid        	
	 * @param unknown $command        	
	 * @param string $resp        	
	 * @return boolean
	 */
	public function addCommand($sid, $cname, $command, $saltid = "", $resp = "") {
		global $table_prefix;
		if (! (new pmxHost ())->isExistSaltID ( $sid )) {
			return FALSE;
		}
		if ($saltid == "")
			$saltid = $this->newSaltID ();
		$time = get_time ();
		$respTime = "";
		if (trim ( $resp ) != "")
			$respTime = get_time ();
		try {
			$sth = $this->dbh->prepare ( "INSERT INTO {$table_prefix}hostLogs(`saltid`,`sid`,`cname`,`command`,`resp`,`time`,`respTime`) VALUES( :saltid, :sid, :cname, :command, :resp, :time, :respTime)" );
			$sth->bindParam ( ':saltid', $saltid );
			$sth->bindParam ( ':sid', $sid );
			$sth->bindParam ( ':cname', $cname );
			$sth->bindParam ( ':command', $command );
			$sth->bindParam ( ':resp', $resp );
			$sth->bindParam ( ':time', $time );
			$sth->bindParam ( ':respTime', $respTime );
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
	 * 添加主机返回信息
	 * 
	 * @param unknown $saltid        	
	 * @param unknown $resp        	
	 * @return boolean
	 */
	public function addResp($saltid, $resp) {
		global $table_prefix;
		if (! $this->isExistSaltID ( $saltid )) {
			return FALSE;
		}
		$respTime = get_time ();
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}hostLogs SET `resp` = :resp, `respTime` = :respTime WHERE `saltid` = :saltid" );
			$sth->bindParam ( ':saltid', $saltid );
			$sth->bindParam ( ':resp', $resp );
			$sth->bindParam ( ':respTime', $respTime );
			$sth->execute ();
			if (! ($sth->rowCount () > 0)) {
				return FALSE;
			}
			return TRUE;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 生成新saltid
	 * 
	 * @return string
	 */
	public function newSaltID() {
		$saltid = (new pmxHost ())->newSaltID ( 10 );
		while ( $this->isExistSaltID ( $saltid ) ) {
			$saltid = (new pmxHost ())->newSaltID ( 10 );
		}
		return $saltid;
	}
	
	/**
	 * 更新状态
	 * 
	 * @return boolean
	 */
	public function updateStatus() {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}hostLogs SET `resp` = 'Timeout' WHERE ABS(UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(`time`)) > 15 AND UNIX_TIMESTAMP(`respTime`) = 0" );
			$sth->execute ();
			if (! ($sth->rowCount () > 0)) {
				return FALSE;
			}
			return TRUE;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
}