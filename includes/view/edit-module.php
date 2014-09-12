<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
?>
<?php pmx_require_header("Edit Module"); ?>
<?php pmx_require_nav(""); ?>
<?php

$id = isset ( $_GET ["id"] ) ? intval ( $_GET ["id"] ) : NULL;
$pmxModule = new pmxModule ();
if (! $pmxModule->isExistID ( $id )) {
	die ( "Error: The module id is non-existent." );
}
$data = $pmxModule->getDetail ( $id );
?>
<div class="main">
	<div class="main-item-single main-item-add-module pull-left">
		<form class="form-horizontal" id="form-add-mod"
			action="<?php echo pmx_getactionurl_savemod(); ?>" method="POST"
			role="form">
			<div
				class="main-item-single-block main-item-single-addmodule-setting">
				<div class="add-module-item add-module-item-1">
					<div class="form-group">
						<label for="inputName" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-9">
							<input type="text" name="name" class="form-control"
								id="inputName" placeholder="Module Name"
								value="<?php echo esc_html($data["name"]);?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputDesc" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-9">
							<textarea name="desc" class="form-control" id="inputDesc"
								placeholder="Module Description"><?php echo esc_html($data["desc"]);?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="inputCat" class="col-sm-2 control-label">Catalogue</label>
						<div class="col-sm-9">
							<label class="radio-inline"> <input type="radio"
								name="optionsCat" id="optionsCat1" value="0"
								<?php if($data["cat"] == 0) echo "checked";?>>Default
							</label> <label class="radio-inline"> <input type="radio"
								name="optionsCat" id="optionsCat2" value="1"
								<?php if($data["cat"] == 1) echo "checked";?>>EXP
							</label> <label class="radio-inline"> <input type="radio"
								name="optionsCat" id="optionsCat3" value="2"
								<?php if($data["cat"] == 2) echo "checked";?>>Custom
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="inputOnly" class="col-sm-2 control-label">Only</label>
						<div class="col-sm-9">
							<label class="radio-inline"> <input type="radio"
								name="optionsOnly" id="optionsOnly1" value="1"
								<?php if($data["only"] == 1) echo "checked";?>>Yes
							</label> <label class="radio-inline"> <input type="radio"
								name="optionsOnly" id="optionsOnly2" value="0"
								<?php if($data["only"] == 0) echo "checked";?>>No
							</label>
						</div>
					</div>
				</div>
			</div>
			<div
				class="main-item-single-block main-item-single-addmod-module-config">
				<div class="add-module-item add-module-item-2">
					<p>
						Project ID : {pmx.system.projid}<br> Project URL :
						{pmx.system.projurl}<br> Define a const : {pmx.define.xxx}<br>
						Describe the const : {pmx.define.xxx.desc, "The name of xxx"}
					</p>
					<p>
						<b>Example:</b><br>
						<code>
							//{pmx.define.url.desc, "Redirection URL"}<br>//{pmx.define.info.desc,
							"The text to alert"}<br>alert("{pmx.define.xxx}");<br>location.replace("{pmx.define.url}");
						</code>
					</p>
				</div>
			</div>
			<div
				class="main-item-single-block main-item-single-addmod-module-code">
				<div class="add-module-item add-module-item-3">
					<div class="form-group">
						<label for="inputCode" class="col-sm-2 control-label">Code</label>
						<div class="col-sm-9">
							<textarea name="code" class="form-control" rows="13"
								id="inputCode" placeholder="Module Code"><?php echo esc_html($data["code"]);?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div
				class="main-item-single-block main-item-single-addmod-module-submit">
				<input type="hidden" name="id" value="<?php echo esc_html($id);?>">
				<input type="hidden" name="token"
					value="<?php echo esc_html(pmx_get_token());?>">
				<button class="btn btn-primary pull-right" type="submit">Save This
					Module</button>
			</div>
		</form>
	</div>
</div>

<?php pmx_require_footer(); ?>