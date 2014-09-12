<?php
/**
 * 错误访问本文件返回
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}

/**
 * 返回主页
 */
pmx_gourl_home ();
?>