<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
?>
<?php pmx_require_header("Module List"); ?>
<?php pmx_require_nav(".nav-left-module"); ?>
<div class="main">
	<div class="top-bar">
		<div class="top-bar-item">
			<a href="<?php echo  get_mod_caturl("DEFAULT"); ?>"
				urladd="cat[]=DEFAULT">Default</a> <a
				href="<?php echo  get_mod_caturl("EXP"); ?>" urladd="cat[]=EXP">EXP</a>
			<a href="<?php echo  get_mod_caturl("CUSTOM"); ?>"
				urladd="cat[]=CUSTOM">Custom</a>
		</div>
	</div>
	<div class="main-item-bar">
		<div class="button">
			<a href="<?php echo pmx_geturl_addmod(); ?>" type="button"
				class="btn btn-default btn-xs btn-add"><span
				class="glyphicon glyphicon-plus"></span> Add Module</a>
			<button type="button" class="btn btn-default btn-xs btn-checkall"
				status="unchecked">
				<span class="glyphicon glyphicon-check"></span> Select All
			</button>
			<button type="button"
				class="btn btn-default btn-xs btn-delete-item del-module"
				data-toggle="modal" data-target="#delmods">
				<span class="glyphicon glyphicon-remove"></span> Delete
			</button>
		</div>
		<div class="pagination">
			<span><small><?php echo esc_html(get_mod_page_item_range()); ?>, Total <?php echo get_module_num(); ?> </small></span>
			<a type="button" class="btn btn-default btn-xs btn-page"
				href="<?php echo get_mod_prevpageurl(); ?>"><span
				class="glyphicon glyphicon-chevron-left"></span> Prev</a> <a
				type="button" class="btn btn-default btn-xs btn-page"
				href="<?php echo get_mod_nextpageurl(); ?>">Next <span
				class="glyphicon glyphicon-chevron-right"></span></a>
		</div>

	</div>
<?php
$mods = get_module_list ();
foreach ( $mods as $mod ) {
	?>
	<div class="main-item main-item-module">
		<div class="main-item-name pull-left  cursor-pointer">
			<?php if($mod['deletable'] == 1){ ?><input style="margin: 0;"
				type="checkbox" class="s_checkbox" value="<?php echo $mod['id']; ?>"><?php }?>
			<a
				href="<?php echo (($mod['editable'] == 1))?pmx_geturl_editmod($mod['id']):"#";?>"><?php echo  esc_html($mod['id'].":".$mod['name']);?></a>
		</div>
		<div class="main-item-body pull-left">
			<div class="desc"><?php echo  esc_html($mod['desc']);?></div>
		</div>
		<div class="main-item-footer pull-left">
			<div class="main-item-footer-operater">
					<?php if($mod['editable'] == 1){ ?>
					<a class="setting"
					href="<?php echo pmx_geturl_editmod($mod['id']); ?>"
					title="Setting"><span class="setting"></span></a>
					<?php }?>
					<?php if($mod['deletable'] == 1){ ?>
					<a class="delete"
					href="<?php echo pmx_getactionurl_delmod($mod['id']); ?>"
					onclick="return confirm('Are sure to delete the module which id is <?php echo $mod['id']; ?>?');"
					title="Delete"><span class="delete"></span></a>
					<?php }?>
			</div>
		</div>
	</div>
<?php } ?>
</div>
<?php pmx_require_footer(); ?>