<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
?>
<?php pmx_require_header("Login"); ?>
<div class="login">
	<form role="form" class="form-signin" id="login_form"
		action="<?php echo pmx_getactionurl_login(); ?>" method="post">
		<p>
			<label for="inputUsername">Username</label> <input type="text"
				id="inputUsername" name="username" class="form-control"
				placeholder="Username" check-type="required" required=""
				autofocus="">
		</p>
		<p>
			<label for="inputPassword">Password</label> <input type="password"
				id="inputPassword" name="password" class="form-control"
				placeholder="Password" check-type="required" required="">
		</p>
		<p style="text-align: center; font-size: 9px; color: red;"></p>
		<hr>
		<p></p>
		<p>
			<button class="btn btn-primary btn-lg btn-block" type="submit">登录</button>
		</p>
	</form>
</div>
<?php pmx_require_footer(); ?>