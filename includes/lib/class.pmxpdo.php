<?php
/**
 * 自定义PDO继承类
 * 
 */
class pmxPDO extends PDO {
	public function __construct($dsn, $user = NULL, $pass = NULL, $driver_options = NULL) {
		
		// Temporarily change the PHP exception handler while we . . .
		set_exception_handler ( array (
				__CLASS__,
				'exception_handler' 
		) );
		
		// . . . create a PDO object
		parent::__construct ( $dsn, $user, $pass, $driver_options );
		
		// Change the exception handler back to whatever it was before
		restore_exception_handler ();
	}
	public static function exception_handler($exception) {
		// Output the exception details
		header ( 'Content-Type: text/plain; charset=utf-8' );
		die ( "Error!: " . $exception->getMessage () );
	}
}