<?php
/**
 * This file is from PHPMailer
 * @link https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
 * @author Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
 * @author Jim Jagielski (jimjag) <jimjag@gmail.com>
 * @author Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 * @author Brent R. Matzelle (original founder)
 * @copyright 2012 - 2014 Marcus Bointon
 * @copyright 2010 - 2012 Jim Jagielski
 * @copyright 2004 - 2009 Andy Prevost
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */

/**
 * phpMy XSS SPL autoloader.
 * 
 * @param string $classname
 *        	The name of the class to load
 */
function pmx_autoload($classname) {
	// Can't use __DIR__ as it's only in PHP 5.3+
	$filename = dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'lib/class.' . strtolower ( $classname ) . '.php';
	if (is_readable ( $filename )) {
		require $filename;
	}
}

if (version_compare ( PHP_VERSION, '5.1.2', '>=' )) {
	// SPL autoloading was introduced in PHP 5.1.2
	if (version_compare ( PHP_VERSION, '5.3.0', '>=' )) {
		spl_autoload_register ( 'pmx_autoload', true, true );
	} else {
		spl_autoload_register ( 'pmx_autoload' );
	}
} else {
	/**
	 * Fall back to traditional autoload for old PHP versions
	 * 
	 * @param string $classname
	 *        	The name of the class to load
	 */
	function __autoload($classname) {
		pmx_autoload ( $classname );
	}
}
