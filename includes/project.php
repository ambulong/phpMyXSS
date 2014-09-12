<?php
/**
 * 获取项目列表
 * @return multitype:
 */
function get_project_list() {
	return (new pmxProjects ())->getProjList ();
}

/**
 * 获取项目记录数量
 * 
 * @param unknown $id        	
 * @return Ambigous <boolean, unknown>
 */
function get_projectItem_num($id) {
	return (new pmxProject ())->getItemNum ( $id );
}

/**
 * 获取项目名
 * 
 * @param unknown $id        	
 * @return Ambigous <>
 */
function get_project_name($id) {
	$detail = (new pmxProject ())->getDetail ( $id );
	return $detail ['name'];
}