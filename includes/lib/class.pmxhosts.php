<?php
/**
 * 主机列表操作类
 * @author ambulong
 *
 */
class pmxHosts {
	private $dbh = NULL;
	public function __construct() {
		$this->dbh = $GLOBALS ["pmx_dbh"];
		$this->updateStatus ();
	}
	
	/**
	 * 获取主机列表
	 * 
	 * @param number $offset        	
	 * @param string $row        	
	 * @return multitype:
	 */
	public function getHostList($offset = 0, $row = NULL, $status = "'%'", $pid = "'%'", $device = "'%'") {
		global $table_prefix;
		$offset = intval ( $offset );
		$row = intval ( $row );
		$status_query = ":status";
		$pid_query = ":pid";
		$device_query = ":device";
		if ($status == "'%'")
			$status_query = "'%'";
		if ($pid == "'%'")
			$pid_query = "'%'";
		if ($device == "'%'")
			$device_query = "'%'";
		try {
			if ($row == NULL)
				$sth = $this->dbh->prepare ( "SELECT * FROM (SELECT * FROM {$table_prefix}hosts ORDER BY `id` DESC) AS NEW WHERE `status` LIKE {$status_query} AND `pid` LIKE {$pid_query} AND `device` LIKE {$device_query} GROUP BY `ip`  ORDER BY `id` DESC" );
			else
				$sth = $this->dbh->prepare ( "SELECT * FROM (SELECT * FROM {$table_prefix}hosts ORDER BY `id` DESC) AS NEW WHERE `status` LIKE {$status_query} AND `pid` LIKE {$pid_query} AND `device` LIKE {$device_query} GROUP BY `ip`  ORDER BY `id` DESC LIMIT {$offset},{$row}" );
			if ($status != "'%'")
				$sth->bindParam ( ':status', $status );
			if ($pid != "'%'")
				$sth->bindParam ( ':pid', $pid );
			if ($device != "'%'")
				$sth->bindParam ( ':device', $device );
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
	 * 获取所有主机
	 * 
	 * @return multitype:
	 */
	public function getAllHostList() {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}hosts" );
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
	 * 获取主机数量
	 * 
	 * @param string $status        	
	 * @param string $pid        	
	 * @param string $device        	
	 * @return number
	 */
	public function getHostNum($status = "'%'", $pid = "'%'", $device = "'%'") {
		global $table_prefix;
		$status_query = ":status";
		$pid_query = ":pid";
		$device_query = ":device";
		if ($status == "'%'")
			$status_query = "'%'";
		if ($pid == "'%'")
			$pid_query = "'%'";
		if ($device == "'%'")
			$device_query = "'%'";
			// echo "$status_query + $pid_query + $device_query";
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}hosts WHERE `status` LIKE {$status_query} AND `pid` LIKE {$pid_query} AND `device` LIKE {$device_query} GROUP BY `ip`" );
			if ($status != "'%'")
				$sth->bindParam ( ':status', $status );
			if ($pid != "'%'")
				$sth->bindParam ( ':pid', $pid );
			if ($device != "'%'")
				$sth->bindParam ( ':device', $device );
			$sth->execute ();
			$result = $sth->fetchAll ( PDO::FETCH_ASSOC );
			// var_dump($result);
			return count ( $result );
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取IP下SID列表
	 * 
	 * @param number $offset        	
	 * @param string $row        	
	 * @return multitype:
	 */
	public function getSIDList($ip) {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}hosts WHERE `ip` = :ip  ORDER BY `id` DESC" );
			$sth->bindParam ( ':ip', $ip );
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
	 * 获取有主机项目列表
	 * 
	 * @param number $offset        	
	 * @param string $row        	
	 * @return multitype:
	 */
	public function getProjs() {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}hosts GROUP BY `pid`  ORDER BY `id` DESC" );
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
	 * 更新状态
	 * 
	 * @return boolean
	 */
	public function updateStatus() {
		/**
		 * 注释掉的效率太低
		 */
		/*
		 * $detail = $this->getAllHostList(); if(count($detail) <= 0) return TRUE; $pmxHost = new pmxHost(); foreach($detail as $detail_item){ $pmxHost->updateStatus($detail_item['sid']); } return TRUE;
		 */
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}hosts SET `status` = '0' WHERE ABS(UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(`lastestRequest`)) > 15" );
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