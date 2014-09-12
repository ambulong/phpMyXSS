<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
?>
<script language="javascript">
	$(function(){
		$("<?php echo pmx_get_navactive(); ?>").addClass("selected");
	});
</script>
</body>
</html>