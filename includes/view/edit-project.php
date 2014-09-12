<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
?>
<?php pmx_require_header("Edit Project"); ?>
<?php pmx_require_nav(""); ?>
<?php

$id = isset ( $_GET ["id"] ) ? intval ( $_GET ["id"] ) : NULL;
$pmxProj = new pmxProject ();
if (! $pmxProj->isExistID ( $id )) {
	die ( "Error: The Project id is non-existent." );
}
$data = $pmxProj->getDetail ( $id );
$modids = json_decode ( $data ['mods'], true );
?>
<div class="main">
	<div class="main-item-single main-item-add-proj pull-left">
		<form class="form-horizontal" id="form-add-proj"
			action="<?php echo pmx_getactionurl_saveproj(); ?>" method="POST"
			role="form">
			<div
				class="main-item-single-left main-item-single-addproj-setting  pull-left">
				<div class="add-proj-item add-proj-item-1">
					<div class="form-group">
						<label for="inputTitle" class="col-sm-2 control-label">Title</label>
						<div class="col-sm-9">
							<input type="text" name="title" class="form-control"
								id="inputTitle" value="<?php echo esc_html($data['name']); ?>"
								placeholder="Project Title" check-type="required" required="">
						</div>
					</div>
					<div class="form-group">
						<label for="inputDesc" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-9">
							<textarea name="desc" class="form-control" id="inputDesc"
								placeholder="Project Description" check-type="required"
								required=""><?php echo esc_html($data['desc']); ?></textarea>
						</div>
					</div>
				</div>
				<div class="add-proj-item add-proj-item-2">
					<div class="form-group">
						<label for="inputStatus" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-9">
							<label class="radio-inline"> <input type="radio"
								name="optionsStatus" id="optionsStatus1" value="1"
								<?php echo ($data['status'] == 1)?"checked":""; ?>>On
							</label> <label class="radio-inline"> <input type="radio"
								name="optionsStatus" id="optionsStatus2" value="0"
								<?php echo ($data['status'] == 0)?"checked":""; ?>>Off
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="inputProtect" class="col-sm-2 control-label">Pack</label>
						<div class="col-sm-9">
							<label class="radio-inline"> <input type="radio"
								name="optionsProtect" id="optionsProtect1" value="1"
								<?php echo ($data['protection'] == 1)?"checked":""; ?>>On
							</label> <label class="radio-inline"> <input type="radio"
								name="optionsProtect" id="optionsProtect2" value="0"
								<?php echo ($data['protection'] == 0)?"checked":""; ?>>Off
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="inputMailAlert" class="col-sm-2 control-label">Mail
							Alert</label>
						<div class="col-sm-9">
							<label class="radio-inline"> <input type="radio"
								name="optionsMail" id="optionsMail1" value="1"
								<?php echo ($data['mailAlert'] == 1)?"checked":""; ?>>On
							</label> <label class="radio-inline"> <input type="radio"
								name="optionsMail" id="optionsMail2" value="0"
								<?php echo ($data['mailAlert'] == 0)?"checked":""; ?>>Off
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="inputMail" class="col-sm-2 control-label">Mail</label>
						<div class="col-sm-9">
							<input type="text" name="mail" class="form-control"
								id="inputMail" placeholder="Your E-mail"
								value="<?php echo esc_html($data['mail']); ?>">
						</div>
					</div>
				</div>
			</div>
			<div
				class="main-item-single-right main-item-single-addproj-module pull-left">
				<div class="add-proj-item add-proj-item-4 add-proj-item-module">
<?php
$mods = get_module_list ();
foreach ( $mods as $mod ) {
	?>
					  <div
						class="module-item <?php echo (in_array($mod['id'], $modids))?"preselected":""; ?>"
						only="<?php echo esc_html($mod['only']);?>"
						id="<?php echo esc_html($mod['id']);?>"
						url="<?php echo pmx_getapiurl_modconfig($mod['id']);?>">
						<a href="#"><span class="name"><?php echo esc_html($mod['name']);?></span>
							- <span class="desc"><?php echo esc_html($mod['desc']);?></span></a>
					</div>
<?php } ?>
				</div>
			</div>
			<div
				class="main-item-single-left main-item-single-addproj-mod-setting pull-left">
				<div class="add-proj-item add-proj-item-5">
					<div class="form-group form-group-comments">
						<label for="inputComments" class="col-sm-2 control-label">Comments</label>
						<div class="col-sm-9">
							<textarea name="comments" class="form-control" id="inputComments"
								placeholder="Project Comments"><?php echo esc_html($data['comments']); ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div
				class="main-item-single-left pull-left main-item-add-proj-submit">
				<input type="hidden" name="id" value="<?php echo esc_html($id);?>">
				<input type="hidden" name="token"
					value="<?php echo esc_html(pmx_get_token());?>">
				<button class="btn btn-primary pull-right" type="submit">Save This
					Project</button>
			</div>
			<div class="proj-mod-configure" style="display: none;">
<?php
$mod_config = json_decode ( $data ["modConfig"] );
foreach ( $mod_config as $mod_config_item ) {
	?>
				<span
					class="_mod_<?php echo esc_html("$mod_config_item[0]");?>_<?php echo esc_html("$mod_config_item[1]");?>"
					mid="<?php echo esc_html("$mod_config_item[0]");?>"
					define="<?php echo esc_html("$mod_config_item[1]");?>"
					val="<?php echo esc_html("$mod_config_item[2]");?>"><input
					mname="mod_<?php echo esc_html("$mod_config_item[0]");?>_<?php echo esc_html("$mod_config_item[1]");?>"
					value="<?php echo esc_html("$mod_config_item[2]");?>" type="hidden"></span>
<?php }?>
			 </div>
		</form>
	</div>
</div>

<?php pmx_require_footer(); ?>