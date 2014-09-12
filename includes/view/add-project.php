<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
?>
<?php pmx_require_header("Add Project"); ?>
<?php pmx_require_nav(""); ?>

<div class="main">
	<div class="main-item-single main-item-add-proj pull-left">
		<form class="form-horizontal" id="form-add-proj"
			action="<?php echo pmx_getactionurl_addproj(); ?>" method="POST"
			role="form">
			<div
				class="main-item-single-left main-item-single-addproj-setting  pull-left">
				<div class="add-proj-item add-proj-item-1">
					<div class="form-group">
						<label for="inputTitle" class="col-sm-2 control-label">Title</label>
						<div class="col-sm-9">
							<input type="text" name="title" class="form-control"
								id="inputTitle" placeholder="Project Title"
								check-type="required" required="">
						</div>
					</div>
					<div class="form-group">
						<label for="inputDesc" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-9">
							<textarea name="desc" class="form-control" id="inputDesc"
								placeholder="Project Description" check-type="required"
								required=""></textarea>
						</div>
					</div>
				</div>
				<div class="add-proj-item add-proj-item-2">
					<div class="form-group">
						<label for="inputStatus" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-9">
							<label class="radio-inline"> <input type="radio"
								name="optionsStatus" id="optionsStatus1" value="1">On
							</label> <label class="radio-inline"> <input type="radio"
								name="optionsStatus" id="optionsStatus2" value="0" checked>Off
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="inputProtect" class="col-sm-2 control-label">Pack</label>
						<div class="col-sm-9">
							<label class="radio-inline"> <input type="radio"
								name="optionsProtect" id="optionsProtect1" value="1">On
							</label> <label class="radio-inline"> <input type="radio"
								name="optionsProtect" id="optionsProtect2" value="0" checked>Off
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="inputMailAlert" class="col-sm-2 control-label">Mail
							Alert</label>
						<div class="col-sm-9">
							<label class="radio-inline"> <input type="radio"
								name="optionsMail" id="optionsMail1" value="1">On
							</label> <label class="radio-inline"> <input type="radio"
								name="optionsMail" id="optionsMail2" value="0" checked>Off
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="inputMail" class="col-sm-2 control-label">Mail</label>
						<div class="col-sm-9">
							<input type="text" name="mail" class="form-control"
								id="inputMail" placeholder="Your E-mail">
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
					  <div class="module-item"
						only="<?php echo esc_html($mod['only']);?>"
						id="<?php echo esc_html($mod['id']);?>"
						url="<?php echo pmx_getapiurl_modconfig($mod['id']);?>">
						<a href="#"><span class="name"><?php echo esc_html($mod['name']);?></span>
							- <span class="desc"><?php echo esc_html($mod['desc']);?></span></a>
					</div>
<?php } ?>
					  <!-- <div class="module-item"><a href="#">Get Cookies - This is the description of this module. </a></div>
					  <div class="module-item selected"><a href="#">Hook.js - This is the description of this module. </a></div>
					  <div class="module-item"><a href="#">xss.js - This is the description of this module. </a></div>
					  <div class="module-item selected"><a href="#">Internet Explorer 8 - Fixed Col Span ID Full ASLR, DEP & EMET 4.1.X Bypass - This is the description of this module. </a></div>-->
				</div>
			</div>
			<div
				class="main-item-single-left main-item-single-addproj-mod-setting pull-left">
				<div class="add-proj-item add-proj-item-5">
					<div class="form-group form-group-comments">
						<label for="inputComments" class="col-sm-2 control-label">Comments</label>
						<div class="col-sm-9">
							<textarea name="comments" class="form-control" id="inputComments"
								placeholder="Project Comments"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div
				class="main-item-single-left pull-left main-item-add-proj-submit">
				<input type="hidden" name="token"
					value="<?php echo esc_html(pmx_get_token());?>">
				<button class="btn btn-primary pull-right" type="submit">Add This
					Project</button>
			</div>
		</form>
	</div>
</div>

<?php pmx_require_footer(); ?>