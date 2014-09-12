<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
?>
<?php pmx_require_header("Add Module"); ?>
<?php pmx_require_nav(""); ?>

<div class="main">
	<div class="main-item-single main-item-add-module pull-left">
		<form class="form-horizontal" id="form-add-mod"
			action="<?php echo pmx_getactionurl_addmod(); ?>" method="POST"
			role="form">
			<div
				class="main-item-single-block main-item-single-addmodule-setting">
				<div class="add-module-item add-module-item-1">
					<div class="form-group">
						<label for="inputName" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-9">
							<input type="text" name="name" class="form-control"
								id="inputName" placeholder="Module Name">
						</div>
					</div>
					<div class="form-group">
						<label for="inputDesc" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-9">
							<textarea name="desc" class="form-control" id="inputDesc"
								placeholder="Module Description"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="inputCat" class="col-sm-2 control-label">Catalogue</label>
						<div class="col-sm-9">
							<label class="radio-inline"> <input type="radio"
								name="optionsCat" id="optionsCat1" value="0">Default
							</label> <label class="radio-inline"> <input type="radio"
								name="optionsCat" id="optionsCat2" value="1">EXP
							</label> <label class="radio-inline"> <input type="radio"
								name="optionsCat" id="optionsCat3" value="2" checked>Custom
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="inputOnly" class="col-sm-2 control-label">Only</label>
						<div class="col-sm-9">
							<label class="radio-inline"> <input type="radio"
								name="optionsOnly" id="optionsOnly1" value="1">Yes
							</label> <label class="radio-inline"> <input type="radio"
								name="optionsOnly" id="optionsOnly2" value="0" checked>No
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
								id="inputCode" placeholder="Module Code"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div
				class="main-item-single-block main-item-single-addmod-module-submit">
				<input type="hidden" name="token"
					value="<?php echo esc_html(pmx_get_token());?>">
				<button class="btn btn-primary pull-right" type="submit">Add This
					Module</button>
			</div>
		</form>
	</div>
</div>

<?php pmx_require_footer(); ?>