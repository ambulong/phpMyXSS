<?php
/**
 * 初始化程序类
 * @author Ambulong
 *
 */
class PMX {
	private $DBH = NULL; // OPD数据连接句柄
	public function __construct() {
	}
	/**
	 * Initialize the environment and template.
	 */
	public function init() {
		$this->initPDO ();
		require_once (PMX_ABSPATH . 'settings.php');
		$this->initRouter ();
	}
	
	/**
	 * Connect to MySQL server and set the environment.
	 */
	public function initPDO() {
		try {
			$this->DBH = new pmxPDO ( "mysql:host=" . PMX_DB_HOST . ";dbname=" . PMX_DB_NAME . ";charset=" . PMX_DB_CHARSET, PMX_DB_USER, PMX_DB_PASSWORD, array (
					PDO::ATTR_PERSISTENT => true 
			) );
			$this->DBH->setAttribute ( PDO::ATTR_EMULATE_PREPARES, false );
			$this->DBH->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$this->DBH->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
			$GLOBALS ["pmx_dbh"] = $this->DBH;
		} catch ( Exception $e ) {
			header ( 'Content-Type: text/plain; charset=utf-8' );
			die ( "Error!: " . $e->getMessage () );
		}
	}
	
	/**
	 * Initialize the router.
	 */
	public function initRouter() {
		$router = new pmxRouter ();
		$router->init ();
	}
}