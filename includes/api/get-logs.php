<?php
/**
 * 获取主机记录
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
if (! pmx_validate_token ()) {
	die ( "Token is incorrect." );
}
$type_allow = array (
		"executed",
		"waiting" 
); // 允许的类型
$sid = isset ( $_GET ["sid"] ) ? $_GET ["sid"] : NULL;
$type = isset ( $_GET ["type"] ) ? $_GET ["type"] : NULL;
$top = isset ( $_GET ["top"] ) ? intval ( $_GET ["top"] ) : 10;
if ($sid == NULL || $type == NULL) {
	json_out ( 0, "sid or type couldn't be NULL." );
}
if (! in_array ( $type, $type_allow )) {
	json_out ( 0, "Type is invalid." );
}
$pmxHost = new pmxHost ();
if (! $pmxHost->isExistSaltID ( $sid )) {
	json_out ( 0, "sid is non-existent." );
}
if ($type == "executed") {
	$hostExecutedLogs = $pmxHost->getExecutedLogs ( $sid );
	if (! count ( $hostExecutedLogs ) > 0) {
		json_out ( 1, "", "<p><center>Empty</center></p>" );
	}
	$html = "";
	$index = 0;
	foreach ( $hostExecutedLogs as $hostExecutedLogs_item ) {
		if ($index >= $top)
			break;
		$index ++;
		$resp = json_decode ( $hostExecutedLogs_item ['resp'], TRUE );
		$resp_data = "";
		if (count ( $resp ) > 0) {
			foreach ( $resp as $resp_index => $resp_item ) {
				$resp_data = $resp_data . "<p><span class=\"name\">" . esc_html ( $resp_index ) . " : </span>" . esc_html ( $resp_item ) . "</p>";
			}
		}
		$html = $html . "
		<div class=\"item\">
	 		<a><span class=\"time\">" . $hostExecutedLogs_item ['id'] . " : " . $hostExecutedLogs_item ['time'] . " &gt; </span>" . esc_html ( $hostExecutedLogs_item ['cname'] ) . "</a>
	 		" . $resp_data . "
	 		<p><span class=\"name\">Response Time : </span>" . $hostExecutedLogs_item ['respTime'] . "</p>
	 	</div>
		";
	}
	json_out ( 1, "", $html );
} else {
	$hostWaitingLogs = $pmxHost->getLogs ( $sid );
	if (! count ( $hostWaitingLogs ) > 0) {
		json_out ( 1, "", "<center>Empty</center>" );
	}
	$html = "";
	$index = 0;
	foreach ( $hostWaitingLogs as $hostWaitingLogs_item ) {
		if ($index >= $top)
			break;
		$index ++;
		$html = $html . "<div class=\"item\"><a>Waiting : " . $hostWaitingLogs_item ['id'] . " : " . $hostWaitingLogs_item ["time"] . " &gt; " . esc_html ( $hostWaitingLogs_item ["cname"] ) . "</a></div>";
	}
	json_out ( 1, "", $html );
}
function json_out($status = 0, $msg = "", $data = "") {
	header ( 'Content-Type: text/json; charset=utf-8' );
	die ( json_encode ( array (
			"status" => "{$status}",
			"msg" => "{$msg}",
			"data" => $data 
	) ) );
}