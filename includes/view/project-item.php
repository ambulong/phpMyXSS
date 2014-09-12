<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
?>
<?php pmx_require_header("Item Detail"); ?>
<?php pmx_require_nav(".nav-left-proj"); ?>
<?php

$pmxItem = new pmxProjectItem ();
$id = isset ( $_GET ['id'] ) ? $_GET ["id"] : "";
if (! $pmxItem->isExistID ( $id )) {
	die ( "Error: The item id is invalid." );
}
$detail = $pmxItem->getDetail ( $id );
$data = json_decode ( $detail ['data'], true );
unset ( $detail ["data"] );
?>

<div class="main">
	<div class="main-item-single main-item-projs-item-detail pull-left">
		<div class="projs-item-detail-body">
			<table class="table table-condensed table-bordered">
<?php
foreach ( $detail as $index => $detail_item ) {
	if ($detail_item != "") {
		?>
				<tr>
					<td><b><?php echo esc_html($index);?></b></td>
					<td style="word-break: break-all;"><?php echo esc_html($detail_item);?></td>
				</tr>
<?php
	}
}
?>
			</table>
<?php if(count($data) > 0){ ?>
			<table class="table table-condensed table-bordered">
	<?php
	foreach ( $data as $index => $data_item ) {
		?>
				<tr>
					<td><b><?php echo esc_html($index);?></b></td>
					<td style="word-break: break-all;"><?php echo esc_html($data_item);?></td>
				</tr>
	<?php
	}
	?>
			</table>
<?php } ?>
		</div>
	</div>

<?php pmx_require_footer(); ?>