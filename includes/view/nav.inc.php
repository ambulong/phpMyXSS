<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
?>
<div class="nav-top pull-left">
	<div class="nav-item nav-icon pull-left">
		<span class="icon"></span><span class="tip"></span>
	</div>
	<div class="nav-item nav-title pull-left"><?php echo esc_html(pmx_get_username());?></div>
	<div class="nav-search pull-right">
		<form class="navbar-form" role="search" method="GET"
			action="<?php echo pmx_getactionurl_search(); ?>">
			<div class="form-group">
				<input type="text" class="form-control"
					placeholder="Search in Cookies">
			</div>
			<button type="submit" class="btn btn-default">&nbsp;</button>
		</form>
	</div>
</div>
<div class="nav-left pull-left">
	<ul>
		<li class="nav-left-proj "><a
			href="<?php echo pmx_geturl_projlist(); ?>">Proj Mgmt</a><span
			class="tip"></span></li>
		<li class="nav-left-host"><a
			href="<?php echo pmx_geturl_hostlist(); ?>">Host Mgmt</a><span
			class="tip"></span></li>
		<li class="nav-left-module"><a
			href="<?php echo pmx_geturl_modlist(); ?>">Module Mgmt</a><span
			class="tip"></span></li>
		<!-- <li class="nav-left-setting"><a href="<?php echo pmx_geturl_setting(); ?>">Setting</a><span class="tip"></span></li> -->
		<li class="nav-left-logout"><a
			href="<?php echo pmx_geturl_logout(); ?>">Logout</a><span class="tip"></span></li>
	</ul>
</div>