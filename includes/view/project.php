<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
?>
<?php pmx_require_header("Item List"); ?>
<?php pmx_require_nav(".nav-left-proj"); ?>
<?php

$id = isset ( $_GET ['id'] ) ? intval ( $_GET ['id'] ) : "";
if (! is_item_exist ( $id )) {
	die ( "Error : Project id is invalid." );
}
$items = get_item_list ( $id );
?>
<div class="main">
	<div class="top-bar">
		<div class="top-bar-title">
			<?php echo esc_html(get_project_name($id)); ?>
		</div>
	</div>
	<div class="main-item-projs-items-bar">
		<div class="pagination">
			<span><small><?php echo esc_html(get_item_page_item_range());?>, Total <?php echo esc_html(get_item_num($id));?> </small></span>
			<a type="button" class="btn btn-default btn-xs btn-page"
				href="<?php echo get_item_prevpageurl(); ?>"><span
				class="glyphicon glyphicon-chevron-left"></span> Prev</a> <a
				type="button" class="btn btn-default btn-xs btn-page"
				href="<?php echo get_item_nextpageurl(); ?>">Next <span
				class="glyphicon glyphicon-chevron-right"></span></a>
		</div>
		<div class="button">
			<button type="button" class="btn btn-default btn-xs btn-checkall"
				status="unchecked">
				<span class="glyphicon glyphicon-check"></span> Select All
			</button>
			<button type="button"
				class="btn btn-default btn-xs btn-delete-item del-projitem"
				data-toggle="modal" data-target="#delProjItems">
				<span class="glyphicon glyphicon-remove"></span> Delete
			</button>
		</div>

	</div>
	<div class="main-item-single main-item-projs-items pull-left">
	
<?php
$index = 1;
foreach ( $items as $item ) {
	$info = $item ["id"];
	if (trim ( $item ["ip"] ) != "")
		$info = $info . "『IP』" . $item ["ip"];
	if (trim ( $item ["location"] ) != "")
		$info = $info . " -『Location』" . $item ["location"];
	if (trim ( $item ["HTTP_REFERER"] ) != "")
		$info = $info . " -『HTTP_REFERER』" . $item ["HTTP_REFERER"];
	if (trim ( $item ["cookies"] ) != "")
		$info = $info . " -『Cookies』" . $item ["cookies"];
	if (trim ( $item ["HTTP_USER_AGENT"] ) != "")
		$info = $info . " -『HTTP_USER_AGENT』" . $item ["HTTP_USER_AGENT"];
	?>
		<?php if($index%2 != 0){?><div class="projs-row-items"><?php }?>
			<div class="projs-items">
				<div class="main-item-projs-body pull-left">
					<input type="checkbox" class="s_checkbox"
						value="<?php echo $item["id"];?>"> <span class="info"
						href="<?php echo pmx_geturl_itemdetail($item["id"]); ?>"><?php echo esc_html($info); ?></span>
				</div>
				<div class="main-item-projs-footer pull-left">
					<div class="main-item-projs-footer-operater">
						<a class="delete"
							href="<?php echo pmx_getactionurl_delitem($item["id"]);?>"
							onclick="return confirm('Are sure to delete the item which id is <?php echo $item["id"];?>?');"
							title="Delete"><span class="delete"></span></a>
					</div>
				</div>
			</div>
		<?php if($index%2 == 0){?></div><?php }?>
<?php $index++;?>
<?php }?>
		
		
	</div>
</div>

<?php pmx_require_footer(); ?>