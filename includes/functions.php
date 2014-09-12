<?php
/**
 * Is session started
 * @return bool
 */
function is_session_started() {
	if (php_sapi_name () !== 'cli') {
		if (version_compare ( phpversion (), '5.4.0', '>=' )) {
			return session_status () === PHP_SESSION_ACTIVE ? TRUE : FALSE;
		} else {
			return session_id () === '' ? FALSE : TRUE;
		}
	}
	return FALSE;
}
/**
 * Get IP adress
 * 
 * @return String
 */
function get_ip() {
	return $_SERVER ['REMOTE_ADDR'];
}

/**
 * Get current time
 * 
 * @return String
 */
function get_time() {
	return date ( 'Y-m-d H:i:s' );
}

/**
 * Get date
 * 
 * @return String
 */
function get_date() {
	return date ( 'Y-m-d' );
}

/**
 * Is str in formats like json
 *
 * @param String $string        	
 * @return bool
 */
function is_json($string) {
	json_decode ( $string, true );
	return (json_last_error () == JSON_ERROR_NONE);
}

/**
 * Htmlspecialchars
 * 
 * @param String $string        	
 * @return array or string
 */
function esc_html($string) {
	if (is_array ( $string )) {
		foreach ( $string as $key => $val ) {
			$string [$key] = func_htmlhtmlspecialchars ( $val );
		}
	} else {
		$string = htmlspecialchars ( $string );
	}
	return $string;
}

/**
 * Get current page URL
 *
 * @return string
 */
function get_url() {
	$ssl = (! empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == 'on') ? true : false;
	$sp = strtolower ( $_SERVER ['SERVER_PROTOCOL'] );
	$protocol = substr ( $sp, 0, strpos ( $sp, '/' ) ) . (($ssl) ? 's' : '');
	$port = $_SERVER ['SERVER_PORT'];
	$port = ((! $ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
	$host = isset ( $_SERVER ['HTTP_X_FORWARDED_HOST'] ) ? $_SERVER ['HTTP_X_FORWARDED_HOST'] : isset ( $_SERVER ['HTTP_HOST'] ) ? $_SERVER ['HTTP_HOST'] : $_SERVER ['SERVER_NAME'];
	return $protocol . '://' . $host . $port . $_SERVER ['REQUEST_URI'];
}

/**
 * Get user browser and host information
 * 
 * @return string(array)
 */
function get_user_info() {
	$data = array (
			"ip" => $_SERVER ["REMOTE_ADDR"],
			"time" => get_time (),
			"HTTP_ACCEPT" => @$_SERVER ["HTTP_ACCEPT"],
			"HTTP_HOST" => @$_SERVER ["HTTP_HOST"],
			"HTTP_REFERER" => @$_SERVER ["HTTP_REFERER"],
			"HTTP_USER_AGENT" => @$_SERVER ["HTTP_USER_AGENT"] 
	);
	return $data;
}

/**
 * Send mail
 */
function pmx_mail($mailto, $title, $body, $altbody = '') {
	require (ROOT_PATH . '/PHPMailer/PHPMailerAutoload.php');
	
	$mail = new PHPMailer ();
	
	$mail->isSMTP (); // Set mailer to use SMTP
	$mail->Host = 'smtp.exmail.qq.com;hwsmtp.exmail.qq.com'; // Specify main and backup server
	$mail->SMTPAuth = true; // Enable SMTP authentication
	$mail->Username = 'auto@jooi.me'; // SMTP username
	$mail->Password = ''; // SMTP password
	$mail->CharSet = "UTF-8";
	
	$mail->From = 'auto@jooi.me';
	$mail->FromName = 'Jooi.me';
	$mail->addAddress ( $mailto ); // Name is optional
	$mail->addReplyTo ( 'auto@jooi.me', 'Jooi.me' );
	
	$mail->isHTML ( true ); // Set email format to HTML
	
	$mail->Subject = $title;
	$mail->Body = $body;
	$mail->AltBody = $altbody;
	
	if (! $mail->send ()) {
		echo '<br>Message could not be sent.';
		echo '<br>Mailer Error: ' . $mail->ErrorInfo;
		return 0;
	} else {
		return 1;
	}
}

/**
 * HTML颜色转RGB
 * 
 * @param unknown $color        	
 * @param string $returnstring        	
 * @return boolean|string|multitype:number
 */
function html2rgb($color, $returnstring = false) {
	if ($color [0] == '#')
		$color = substr ( $color, 1 );
	if (strlen ( $color ) == 6)
		list ( $r, $g, $b ) = array (
				$color [0] . $color [1],
				$color [2] . $color [3],
				$color [4] . $color [5] 
		);
	elseif (strlen ( $color ) == 3)
		list ( $r, $g, $b ) = array (
				$color [0] . $color [0],
				$color [1] . $color [1],
				$color [2] . $color [2] 
		);
	else
		return false;
		// $key = 1/255; // use this to get a range from 0 to 1 eg: (0.5, 1, 0.1)
	$key = 1; // use this for normal range 0 to 255 eg: (0, 255, 50)
	$r = hexdec ( $r ) * $key;
	$g = hexdec ( $g ) * $key;
	$b = hexdec ( $b ) * $key;
	if ($returnstring) {
		return "{rgb $r $g $b}";
	} else {
		return array (
				$r,
				$g,
				$b 
		);
	}
}
function uni_encode($word) {
	$word0 = iconv ( 'gbk', 'utf-8', $word );
	$word1 = iconv ( 'utf-8', 'gbk', $word0 );
	$word = ($word1 == $word) ? $word0 : $word;
	$word = json_encode ( $word );
	$word = preg_replace_callback ( '/\\\\u(\w{4})/', create_function ( '$hex', 'return \'&#\'.hexdec($hex[1]).\';\';' ), substr ( $word, 1, strlen ( $word ) - 2 ) );
	return $word;
}
function utf8_urldecode($str) {
	$str = preg_replace ( "/%u([0-9a-f]{3,4})/i", "&#x\\1;", urldecode ( $str ) );
	return html_entity_decode ( $str, null, 'UTF-8' );
	;
}

/**
 * 获取域名
 * 
 * @param unknown $referer        	
 * @return unknown
 */
function get_url_domain($referer) {
	preg_match ( "/^(http:\/\/)?([^\/]+)/i", $referer, $matches );
	$domain = isset ( $matches [2] ) ? $matches [2] : "unknow";
	return $domain;
}