<?php
/**
 * 判断用户权限
 */
if (pmx_is_login () == TRUE) {
	if (get_url () == pmx_geturl_login ()) {
		pmx_gourl_home ();
		exit ();
	}
} else {
	if (get_url () != pmx_geturl_login () && get_url () != pmx_getactionurl_login ()) {
		pmx_gourl_login ();
		exit ();
	}
}