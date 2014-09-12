<?php
/**
 * 项目列表操作类
 * @author ambulong
 *
 */
class pmxProjects {
	private $dbh = NULL;
	public function __construct() {
		$this->dbh = $GLOBALS ["pmx_dbh"];
	}
	
	/**
	 * 获取项目列表
	 * 
	 * @return multitype:
	 */
	public function getProjList() {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}projects  ORDER BY `id` DESC" );
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
}