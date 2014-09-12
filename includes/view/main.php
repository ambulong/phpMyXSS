<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
pmx_gourl_projlist ();
?>