<?php
/**
 * 保存项目
 */
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/html; charset=utf-8' );
if (! pmx_validate_token ()) {
	die ( "Token is incorrect." );
}

$allow_optionStatus = array (
		0,
		1 
);
$allow_optionProtect = array (
		0,
		1 
);
$allow_optionMail = array (
		0,
		1 
);

$id = isset ( $_POST ["id"] ) ? $_POST ["id"] : "";
$title = isset ( $_POST ["title"] ) ? $_POST ["title"] : "";
$desc = isset ( $_POST ["desc"] ) ? $_POST ["desc"] : "";
$status = isset ( $_POST ["optionsStatus"] ) ? $_POST ["optionsStatus"] : 0;
$protect = isset ( $_POST ["optionsProtect"] ) ? $_POST ["optionsProtect"] : 0;
$mailAlert = isset ( $_POST ["optionsMail"] ) ? $_POST ["optionsMail"] : 0;
$mail = isset ( $_POST ["mail"] ) ? $_POST ["mail"] : "";
$comments = isset ( $_POST ["comments"] ) ? $_POST ["comments"] : "";
$modid = isset ( $_POST ["modid"] ) ? $_POST ["modid"] : array ();
if (is_array ( $modid )) {
	$modid = array_unique ( $modid );
} else {
	$modid = array ();
}
$modconfig = array ();
if (count ( $modid ) > 0) {
	foreach ( $modid as $modid_item ) {
		if (isset ( $_POST ["mod_" . $modid_item] )) {
			$var = $_POST ["mod_" . $modid_item];
			if (is_array ( $var )) {
				foreach ( $var as $var_item ) {
					if (isset ( $_POST ["mod_" . $modid_item . "_" . $var_item] )) {
						$val = $_POST ["mod_" . $modid_item . "_" . $var_item];
						$modconfig [] = array (
								$modid_item,
								$var_item,
								$val 
						);
					}
				}
			} else {
				if (isset ( $_POST ["mod_" . $modid_item . "_" . $var] )) {
					$val = $_POST ["mod_" . $modid_item . "_" . $var];
					$modconfig [] = array (
							$modid_item,
							$var,
							$val 
					);
				}
			}
		}
	}
}
if ($id == "" || $title == "" || ! in_array ( $status, $allow_optionStatus ) || ! in_array ( $protect, $allow_optionProtect ) || ! in_array ( $mailAlert, $allow_optionMail )) {
	die ( "Error: Something you input is invalid." );
}
$pmxProj = new pmxProject ( $title, $desc, $status, $protect, $mailAlert, $mail, $comments, $modid, $modconfig );
if ($pmxProj->isExistID ( $id ) == FALSE) {
	die ( "Error: Project id is invalid." );
}
if ($pmxProj->updateProj ( $id ) == TRUE) {
	echo "Success: You have updated project \"" . esc_html ( $title ) . "\" successful";
} else {
	echo "Error: Sorry. We are fail to update the project \"" . esc_html ( $title ) . "\".";
}