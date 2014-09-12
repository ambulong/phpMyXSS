<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
?>
<?php pmx_require_header("Host List"); ?>
<?php pmx_require_nav(".nav-left-host"); ?>
<div class="main">
	<div class="top-bar">
		<div class="top-bar-item">
			<a href="<?php echo get_host_caturl("status", "1");?>"
				urladd="status=1">Online</a> <a
				href="<?php echo get_host_caturl("status", "0");?>"
				urladd="status=0">Offline</a>
		</div>
<?php
$hostProjs = get_host_projs ();
if (count ( $hostProjs ) > 0) {
	?>
		<div class="top-bar-item">
<?php foreach($hostProjs as $hostProjs_item){?>
			<a
				href="<?php echo get_host_caturl("pid", $hostProjs_item["pid"]);?>"
				urladd="<?php echo "pid=".$hostProjs_item["pid"];?>"><?php echo esc_html(get_project_name($hostProjs_item["pid"]));?></a>
<?php }?>
		</div>
<?php }?>
		<!-- <div class="top-bar-item">
			<a href="#">Vulnerable</a>
			<a href="#">Unknow</a>
		</div> -->
		<div class="top-bar-item">
			<a href="<?php echo get_host_caturl("device", "mobile");?>"
				urladd="device=mobile">Mobile Phone</a> <a
				href="<?php echo get_host_caturl("device", "computer");?>"
				urladd="device=computer">Computer</a> <a
				href="<?php echo get_host_caturl("device", "tablet");?>"
				urladd="device=tablet">Tablet</a>
		</div>
	</div>
	<div class="main-item-bar">
		<div class="button">
			<button type="button" class="btn btn-default btn-xs btn-checkall"
				status="unchecked">
				<span class="glyphicon glyphicon-check"></span> Select All
			</button>
			<button type="button"
				class="btn btn-default btn-xs btn-delete-item del-hostip">
				<span class="glyphicon glyphicon-remove"></span> Delete
			</button>
			<a type="button"
				href="<?php echo pmx_getactionurl_delOfflineHost();?>"
				onclick="return confirm('Are sure to delete all of the offline sessions ?');"
				class="btn btn-default btn-xs btn-del-offline"><span
				class="glyphicon"></span> Delete Offline Session</a>
		</div>
		<div class="pagination">
			<span><small><?php echo get_host_page_range();?>, Total <?php echo get_host_num();?> </small></span>
			<a type="button" class="btn btn-default btn-xs btn-page"
				href="<?php echo get_host_prevpageurl(); ?>"><span
				class="glyphicon glyphicon-chevron-left"></span> Prev</a> <a
				type="button" class="btn btn-default btn-xs btn-page"
				href="<?php echo get_host_nextpageurl(); ?>">Next <span
				class="glyphicon glyphicon-chevron-right"></span></a>
		</div>

	</div>
<?php
$hostList = get_host_list ();
if (count ( $hostList ) > 0) {
	foreach ( $hostList as $hostList_item ) {
		$domain = get_url_domain ( $hostList_item ["HTTP_REFERER"] );
		if ($domain == "unknow") {
			$domain = get_url_domain ( $hostList_item ["location"] );
		}
		?>
	<div class="main-item main-item-host">
		<div class="main-item-name pull-left  cursor-pointer">
			<input style="margin: 0;" type="checkbox" class="s_checkbox"
				value="<?php echo $hostList_item["ip"]; ?>"> <a
				href="<?php echo pmx_geturl_hostdetail($hostList_item["id"]); ?>"
				target="_blank"><?php echo esc_html($hostList_item["ip"]); ?> ( <?php echo esc_html($domain); ?> )</a>
		</div>
		<div class="main-item-body pull-left">
			<div class="location"
				ip="<?php echo esc_html($hostList_item["ip"]); ?>">Location: Hover
				here to load</div>
			<?php if($hostList_item["status"] == 1){?><a href="#"><span
				class="label label-success">Online</span></a><?php }?>
			<?php if($hostList_item["status"] == 0){?><a href="#"><span
				class="label label-default">Offline</span></a><?php }?>
			<a href="#"><span
				class="label <?php echo ($hostList_item["flash"] == "true")?"label-info":"label-default"; ?>">Flash</span></a>
			<a href="#"><span
				class="label <?php echo ($hostList_item["java"] == "true")?"label-info":"label-default"; ?>">Java</span></a>
			<a href="#"><span class="label label-info">S : <?php echo ($hostList_item["screen"] != "")?esc_html($hostList_item["screen"]):"unknow";?></span></a>
			<a href="#"
				title="<?php echo ($hostList_item["title"] != "")?esc_html($hostList_item["title"]):"unknow";?>"><span
				class="label label-info">T : <?php echo ($hostList_item["title"] != "")?esc_html(mb_substr($hostList_item["title"], 0, 10, "utf-8"))."...":"unknow";?></span></a>
			<a href="#"
				title="<?php echo esc_html(get_project_name($hostList_item["pid"]));?>"><span
				class="label label-info">P : <?php echo esc_html(mb_substr(get_project_name($hostList_item["pid"]), 0, 10, "utf-8")."...");?></span></a>
		</div>
		<div class="main-item-footer pull-left">
			<div class="main-item-host-mark">
				<a href="#"><span
					class="host-device-<?php echo ($hostList_item["device"] != "")?esc_html($hostList_item["device"]):"unknow";?>"></span></a>
				<a href="#"><span
					class="host-system-<?php echo esc_html(host_get_system($hostList_item["HTTP_USER_AGENT"]));?>"></span></a>
				<a href="#"><span
					class="host-browser-<?php echo esc_html(host_get_browser($hostList_item["HTTP_USER_AGENT"]));?>"></span></a>
			</div>
			<div class="main-item-footer-operater">
				<a
					href="<?php echo pmx_getactionurl_delHost($hostList_item["ip"]); ?>"
					onclick="return confirm('Are sure to delete the logs belong to <?php echo esc_html($hostList_item["ip"]); ?> ?');"
					title="Delete" class="delete"><span class="delete"></span></a>
			</div>
		</div>
	</div>
<?php 	}?>
<?php }?>


</div>
<?php pmx_require_footer(); ?>