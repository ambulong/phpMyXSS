<?php
/**
 * 项目记录操作类
 * @author ambulong
 *
 */
class pmxProjectItem {
	private $dbh = NULL;
	private $id = NULL;
	private $ip = NULL;
	private $time = NULL;
	private $pid = NULL;
	private $location = NULL;
	private $toplocation = NULL;
	private $cookies = NULL;
	private $data = NULL;
	private $HTTP_ACCEPT = NULL;
	private $HTTP_REFERER = NULL;
	private $HTTP_USER_AGENT = NULL;
	
	/**
	 * 导入记录信息
	 * 
	 * @param string $pid        	
	 * @param string $location        	
	 * @param string $toplocation        	
	 * @param string $cookies        	
	 * @param unknown $data        	
	 */
	public function __construct($pid = "", $location = "", $toplocation = "", $cookies = "", $data = array()) {
		$this->pid = $pid;
		$this->location = $location;
		$this->toplocation = $toplocation;
		$this->cookies = $cookies;
		$this->data = is_array ( $data ) ? $data : array ();
		
		$this->dbh = $GLOBALS ['pmx_dbh'];
		$this->ip = get_ip ();
		$this->time = get_time ();
		$this->HTTP_ACCEPT = isset ( $_SERVER ["HTTP_ACCEPT"] ) ? $_SERVER ["HTTP_ACCEPT"] : "";
		$this->HTTP_REFERER = isset ( $_SERVER ["HTTP_REFERER"] ) ? $_SERVER ["HTTP_REFERER"] : "";
		$this->HTTP_USER_AGENT = isset ( $_SERVER ["HTTP_USER_AGENT"] ) ? $_SERVER ["HTTP_USER_AGENT"] : "";
	}
	
	/**
	 * 记录ID是否存在
	 * 
	 * @param unknown $id        	
	 * @return boolean
	 */
	public function isExistID($id) {
		$id = intval ( $id );
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}projItems WHERE `id` = :id " );
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
	 * 添加记录
	 * 
	 * @return boolean
	 */
	public function addItem() {
		global $table_prefix;
		$data = json_encode ( $this->data );
		try {
			$sth = $this->dbh->prepare ( "INSERT INTO {$table_prefix}projItems(`pid`,`ip`,`location`,`topLocation`,`cookies`,`time`,`HTTP_ACCEPT`,`HTTP_REFERER`,`HTTP_USER_AGENT`,`data`) VALUES( :pid, :ip, :location, :toplocation, :cookies, :time, :HTTP_ACCEPT, :HTTP_REFERER, :HTTP_USER_AGENT, :data )" );
			$sth->bindParam ( ':pid', $this->pid );
			$sth->bindParam ( ':ip', $this->ip );
			$sth->bindParam ( ':location', $this->location );
			$sth->bindParam ( ':toplocation', $this->toplocation );
			$sth->bindParam ( ':cookies', $this->cookies );
			$sth->bindParam ( ':time', $this->time );
			$sth->bindParam ( ':HTTP_ACCEPT', $this->HTTP_ACCEPT );
			$sth->bindParam ( ':HTTP_REFERER', $this->HTTP_REFERER );
			$sth->bindParam ( ':HTTP_USER_AGENT', $this->HTTP_USER_AGENT );
			$sth->bindParam ( ':data', $data );
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
	 * 获取添加后的记录ID
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
	 * 显示添加后的记录ID
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
	 * 删除记录
	 * 
	 * @param unknown $id        	
	 * @return boolean|unknown
	 */
	public function delItem($id) {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}projItems WHERE `id` = :id " );
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
	 * 获取记录的详细内容
	 * 
	 * @param unknown $id        	
	 * @return boolean|unknown
	 */
	public function getDetail($id) {
		global $table_prefix;
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}projItems WHERE `id` = :id " );
			$sth->bindParam ( ':id', $id );
			$sth->execute ();
			$result = $sth->fetch ( PDO::FETCH_ASSOC );
			return $result;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
}