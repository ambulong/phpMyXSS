<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
?>
<?php pmx_require_header("Project List"); ?>
<?php pmx_require_nav(".nav-left-proj"); ?>
<div class="main">
	<div class="main-item main-item-proj-add cursor-pointer"
		title="Add New Project">
		<div class="proj-add">
			<a href="<?php echo pmx_geturl_addproj(); ?>"></a>
		</div>
	</div>
<?php
$projs = get_project_list ();
foreach ( $projs as $proj ) {
	?>
	<div class="main-item">
		<div class="main-item-name pull-left  cursor-pointer">
			<a href="<?php echo pmx_geturl_projdetail($proj['id']); ?>"><?php echo esc_html($proj['name']);?></a>
		</div>
		<div class="main-item-body pull-left">
			<p class="cursor-pointer"><?php echo esc_html($proj['desc']);?></p>
			<div class="tips">
				<div class="tips-item cursor-pointer">
					<a href="<?php echo pmx_getpuburl_projcode($proj['saltid']);?>"
						target=“_blank”><span class="label label-primary">URL</span></a>
				</div>
				<div class="tips-item cursor-pointer">
					<a href="<?php echo pmx_geturl_projdetail($proj['id']); ?>"><span
						class="label label-info"><?php echo esc_html(get_projectItem_num($proj['id'])); ?></span></a>
				</div>
			</div>
		</div>
		<div class="main-item-footer pull-left">
			<div class="main-item-footer-operater">
				<a href="<?php echo pmx_geturl_editproj($proj['id']); ?>"
					title="Setting"><span class="setting"></span></a> <a
					href="<?php echo ($proj['status'] == 1)?pmx_getactionurl_stopproj($proj['id']):pmx_getactionurl_startproj($proj['id']);?>"
					title="<?php echo ($proj['status'] == 1)?"Stop":"Start"; ?>"><span
					class="<?php echo ($proj['status'] == 1)?"stop":"start"; ?>"></span></a>
				<a href="<?php echo pmx_getactionurl_delproj($proj['id']);?>"
					onclick="return confirm('Are sure to delete the project which id is <?php echo $proj['id']; ?>?');"
					title="Delete"><span class="delete"></span></a>
			</div>
		</div>
	</div>
<?php } ?>
</div>
<?php pmx_require_footer(); ?>