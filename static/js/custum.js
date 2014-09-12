$(function(){

////////////////////////////////////////////////////////
	$.extend({
		doLayout:function(){	/**< 调整布局 */
			if($(".nav-top").width()/$(".nav-icon").width() < 20 ){
				//if($(".nav-title").css("display") != "none")
				//	$(".nav-title").css("display","none");
				if($(".nav-search").css("display") != "none")
					$(".nav-search").css("display","none");
				if($(".nav-left").position().top >= 0)
					$.NavLeftHide();
				if($(".main").css("padding-left") != "0")
					$(".main").css("padding-left", "0");
			}else{
				//if($(".nav-title").css("display") != "inline")
				//	$(".nav-title").css("display","inline");
				if($(".nav-search").css("display") != "inline")
					$(".nav-search").css("display","inline");
				if($(".nav-left").position().top < 0)
					$.NavLeftShow();
				if($(".main").css("padding-left") != "16em")
					$(".main").css("padding-left", "16em");
			}
			$.MainItemLayout();
			$.doAddProjLayout();
			$.doProjsItemsLayout();
			$.doHostsItemLayout();
		}
	});
	$.extend({
		MainItemLayout:function(){
			var content_width = 0;
			var rest_space = 0;
			if($(".nav-top").width()/$(".nav-icon").width() < 20 ){
				content_width = $("body").width();
			}else{
				content_width = $("body").width() - $(".nav-left").width();
			}
			var row_item_num = Math.floor(content_width / ($(".main-item:first").width() + 16));
			var rest_space = content_width - ($(".main-item:first").width() + 16) * row_item_num - row_item_num*2;
			if(rest_space < row_item_num*4){
				row_item_num -- ;
				rest_space = content_width - ($(".main-item:first").width() + 16) * row_item_num - row_item_num*2;
			}
			var margin_side = Math.floor(rest_space / (row_item_num * 2));
			$(".main-item").css("margin","0.5em " + margin_side + "px");
			$(".main-item").css("width", "95%");
		}
	});
	$.extend({
		NavLeftHide:function(){
			if($(".nav-left").position().top >= 0){
				$(".nav-left").css("height", $(".nav-left").height());
				if(0 - $(".nav-left").height() < 0)
					$(".nav-left").css("top", 0 - $(".nav-left").height());
				$(".nav-icon span.tip").hide();
			}
		}
	});
	$.extend({
		NavLeftShow:function(){
			if($(".nav-left").position().top != 0){
				$(".nav-left").css("height", "100%");
				$(".nav-left").css("top", "0");
				$(".nav-icon span.tip").show();
			}
		}
	});
	$.extend({
		SubText:function(str, len){
			if(str.length > len)
				return str.substring(0,len)+"...";
			else
				return str;
		}
	});
	$.extend({
		doSubText:function(){
			$.each($(".main-item-name a"),function(index,item){
				$(item).text($.SubText($(item).text(), 66));
			});
			$.each($(".main-item-module .desc"),function(index,item){
				$(item).text($.SubText($(item).text(), 170));
			});
			$.each($(".main-item-body p"),function(index,item){
				$(item).text($.SubText($(item).text(), 170));
			});
			$.each($(".main-item-host .location"),function(index,item){
				$(item).text($.SubText($(item).text(), 70));
			});
			$.each($(".main-item-projs-body span.info"),function(index,item){
				$(item).text($.SubText($(item).text(), 350));
			});
			/*$.each($(".add-proj-item-module .module-item a"),function(index,item){
				$(item).text($.SubText($(item).text(), 50));
			});*/
		}
	});
	$.extend({
		doAddProjLayout:function(){
			if($(".main-item-add-proj").width()/$(".nav-left").width() < 3 ){
				if($(".main-item-add-proj .main-item-single-left").css("width") != "99%"){
					$(".main-item-add-proj .main-item-single-left").css("width", "99%");
				}
				if($(".main-item-add-proj .main-item-single-right").css("width") != "99%"){
					$(".main-item-add-proj .main-item-single-right").css("width", "99%");
				}
				if($(".main-item-add-proj .main-item-single-addproj-mod-setting").css("margin-top") != "0"){
					$(".main-item-add-proj .main-item-single-addproj-mod-setting").css("margin-top", "0");
				}
			}else{
				if($(".main-item-add-proj .main-item-single-left").css("width") != "60%"){
					$(".main-item-add-proj .main-item-single-left").css("width", "60%");
				}
				if($(".main-item-add-proj .main-item-single-right").css("width") != "39%"){
					$(".main-item-add-proj .main-item-single-right").css("width", "39%");
				}
				if($(".main-item-add-proj .main-item-single-addproj-mod-setting").css("margin-top") != "0"){
					$(".main-item-add-proj .main-item-single-addproj-mod-setting").css("margin-top", "0");
				}
				//console.log($(".main-item-single-addproj-mod-setting").position().top);
				//console.log($(".main-item-single-addproj-mod-setting").css("margin-top"));
				//var mod_setting_margin_top = 0 - ($(".main-item-single-addproj-mod-setting").position().top - ($(".main-item-single-addproj-setting").position().top + $(".main-item-single-addproj-setting").height()));
				var mod_setting_margin_top = $(".main-item-single-addproj-setting").height() - $(".main-item-single-addproj-module").height();
				if(mod_setting_margin_top > 0)
					mod_setting_margin_top = 0;
				if($(".main-item-single-addproj-mod-setting").position().top < ($(".main-item-single-addproj-setting").position().top + $(".main-item-single-addproj-setting").height())){
					console.log("false");
				}
				if($(".main-item-single-addproj-mod-setting").css("margin-top") != mod_setting_margin_top + "px"){
					$(".main-item-single-addproj-mod-setting").css("margin-top", mod_setting_margin_top + "px");
				}
			}
		}
	});
	$.extend({
		doProjsItemsLayout:function(){
			if($(".nav-top").width()/$(".nav-left").width() < 4.1 ){
				if($(".main-item-projs-items .projs-items").css("width") != "100%"){
					$(".main-item-projs-items .projs-items").css("width", "100%");
				}
			}else{
				if($(".main-item-projs-items .projs-items").css("width") != "50%"){
					$(".main-item-projs-items .projs-items").css("width", "50%");
				}
				/*var max_height = 0;
				$.each($(".main-item-projs-items .projs-items .main-item-projs-body .info"),function(index,item){
					if($(item).height() > max_height){
						max_height = $(item).height();
					}
					console.log(index+ ":" + $(item).height());
				});
				$(".main-item-projs-items .projs-items .main-item-projs-body .info").css("min-height", (max_height) + "px");
				console.log("max:" + max_height);*/
			}
			
			//console.log($(".nav-top").width()/$(".nav-left").width());
		}
	});
	$.extend({
		doHostsItemLayout:function(){
			if($(".main-item-hosts-item").width()/$(".nav-left").width() < 3.4 ){
				if($(".main-item-hosts-item .main-item-single-left").css("width") != "99%"){
					$(".main-item-hosts-item .main-item-single-left").css("width", "99%");
				}
				if($(".main-item-hosts-item .main-item-single-right").css("width") != "99%"){
					$(".main-item-hosts-item .main-item-single-right").css("width", "99%");
				}
				if($(".host-mgmt-item-module").css("height") != "20em"){
					$(".host-mgmt-item-module").css("height", "20em");
				}
			}else{
				if($(".main-item-hosts-item .main-item-single-left").css("width") != "60%"){
					$(".main-item-hosts-item .main-item-single-left").css("width", "60%");
				}
				if($(".main-item-hosts-item .main-item-single-right").css("width") != "39%"){
					$(".main-item-hosts-item .main-item-single-right").css("width", "39%");
				}
				if($(".host-mgmt-item-module").css("height") != "32.4em"){
					$(".host-mgmt-item-module").css("height", "32.4em");
				}
			}
		}
	});
	$.extend({
		disablePagination:function(){
			$.each($(".pagination a[type='button']"),function(index, item){
				if($(item).attr("href") == "#") $(item).attr("disabled", true);
			});
		}
	});
	$.extend({
		markTopBarItem:function(){
			var url = window.location.href;
			$.each($(".top-bar-item a"),function(index, item){
				var var_str = $(item).attr("urladd");
				if(url.indexOf(var_str) >= 0){
					$(item).addClass("badge");
				}
			});
		}
	});
	$.extend({
		loadModConfigHtml:function(item){
			$.ajax({
				type:'GET',
				url: $(item).attr("url"),
				dataType:'json',
				success:function(data){
					if(data.status == 1){
						if(data.data != ""){
							$.each(data.data, function(index, data_item){
								var name = data_item[0];
								var desc = data_item[1] + " - " + $(item).children("a").children("span.name").text();
								var html = "<div class=\"form-group form-group-mod-" + $(item).attr("id") + "\"><label for=\"inputTitle\" class=\"col-sm-2 control-label\">" + escapeHtml(name) + "</label><div class=\"col-sm-9\"><input type=\"text\" name=\"mod_" + escapeHtml($(item).attr("id") + "_" + name) + "\" class=\"form-control i8987777666\" id=\"inputTitle\" placeholder=\"" + desc + "\" check-type=\"required\" required=\"\"><input type=\"hidden\" name=\"mod_" + escapeHtml($(item).attr("id")) + "[]\" value=\"" + escapeHtml(name) + "\"><input type=\"hidden\" name=\"modid[]\" value=\"" + $(item).attr("id") + "\"></div></div>";
								$(".main-item-single-addproj-mod-setting .add-proj-item").append(html);
							});
						}else{
							var html = "<div style=\"display:none;\" class=\"form-group form-group-mod-" + $(item).attr("id") + "\"><input type=\"hidden\" name=\"modid[]\" value=\"" + $(item).attr("id") + "\"></div>";
							$(".main-item-single-addproj-mod-setting .add-proj-item").append(html);
						}
					}else{
						alert(data.msg);
					}
				},
				error:function(){
					alert("Error: Fail to load the module configure.");
				}
			});
		}
	});
	$.extend({
		removeModConfigHtml:function(item){
			$(".main-item-single-addproj-mod-setting .add-proj-item").children(".form-group-mod-" + $(item).attr("id")).remove();
		}
	});
	$.extend({
		loadModConfigHtml_:function(item){
			$.ajax({
				type:'GET',
				url: $(item).attr("url"),
				dataType:'json',
				success:function(data){
					if(data.status == 1){
						if(data.data != ""){
							$.each(data.data, function(index, data_item){
								var name = data_item[0];
								var desc = data_item[1] + " - " + $(item).children("a").children("span.name").text();
								var html = "<div class=\"form-group form-group-mod-" + $(item).attr("id") + "\"><label for=\"inputTitle\" class=\"col-sm-2 control-label\">" + escapeHtml(name) + "</label><div class=\"col-sm-9\"><input type=\"text\" name=\"mod_" + escapeHtml($(item).attr("id") + "_" + name) + "\" class=\"form-control i8987777666\" id=\"inputTitle\" placeholder=\"" + desc + "\" check-type=\"required\" required=\"\"><input type=\"hidden\" name=\"mod_" + escapeHtml($(item).attr("id")) + "[]\" value=\"" + escapeHtml(name) + "\"><input type=\"hidden\" name=\"modid[]\" value=\"" + $(item).attr("id") + "\"></div></div>";
								$(".main-item-single-addproj-mod-setting .add-proj-item").append(html);
							});
						}else{
							var html = "<div style=\"display:none;\" class=\"form-group form-group-mod-" + $(item).attr("id") + "\"><input type=\"hidden\" name=\"modid[]\" value=\"" + $(item).attr("id") + "\"></div>";
							$(".main-item-single-addproj-mod-setting .add-proj-item").append(html);
						}
					}else{
						alert(data.msg);
					}
				},
				error:function(){
					alert("Error: Fail to load the module configure.");
				}
			});
		}
	});
	$.extend({
		projEditLoadMod:function(){
			$(".add-proj-item-module .module-item.preselected").click();
			$.each($(".add-proj-item-module .module-item.preselected"), function(index, item){
				$.loadModConfigHtml_($(item));
				$(item).addClass("selected");
				$(item).removeClass("preselected");
			});
		}
	});
	$.extend({
		getIPLocation:function(item){
			$.ajax({
				type:'GET',
				url: "http://freegeoip.net/json/" + $(item).attr("ip"),
				dataType:'json',
				success:function(data){
					var location = data.country_code + " : " 
						+ data.country_name + " " 
						+ data.region_name + " " 
						+ data.city;
					$(item).text(location);
				},
				error:function(){
					console.log("Error: Fail to load the IP Location.");
				}
			});
		}
	});
	$.extend({
		loadAllIPLocation:function(item){
			$.each($(".main-item-host .main-item-body .location"), function(index, item){
				$.getIPLocation($(item));
			});
		}
	});
	$.extend({
		hostMgmtWaitingLogs:function(){
			var url = $(".main-item-hosts-item .host-mgmt-commands .command input[name='addcommandhostlogurl']").val();
			$.ajax({
				type:'GET',
				url: url,
				dataType:'json',
				data:{
					"type": "waiting"
				},
				success:function(data){
					if(data.status == 0){
						console.log(data.msg);
					}else{
						if($(".host-mgmt-commands .waitingresponse").html() != data.data)
							$(".host-mgmt-commands .waitingresponse").html(data.data);
					}
				},
				error:function(){
					console.log("Error: Fail to load waiting logs list.");
				}
			});
		}
	});
	$.extend({
		hostMgmtExecutedLogs:function(){
			var url = $(".main-item-hosts-item .host-mgmt-commands .command input[name='addcommandhostlogurl']").val();
			$.ajax({
				type:'GET',
				url: url,
				dataType:'json',
				data:{
					"type": "executed"
				},
				success:function(data){
					if(data.status == 0){
						console.log(data.msg);
					}else{
						if($(".host-mgmt-commands .response").html() != data.data)
							$(".host-mgmt-commands .response").html(data.data);
					}
				},
				error:function(){
					console.log("Error: Fail to load waiting logs list.");
				}
			});
		}
	});
	$.extend({
		loadHostMgmtLogs:function(){
			$.hostMgmtWaitingLogs();
			$.hostMgmtExecutedLogs();
		}
	});
////////////////////////////////////////////////////////
	$(window).resize(function(){
		$.doLayout();
	});
	$.doLayout();
	$.doSubText();
	$.disablePagination();
	$.markTopBarItem();
	$.projEditLoadMod();
	$.loadAllIPLocation();
//////////////////////////////////////////////////////////////////////
	$(".main-item-footer-operater a").hover(function(){
		var this_class = $(this).children("span").attr("class");
		$(this).children("span").removeClass(this_class);
		$(this).children("span").addClass(this_class + "-hover");
	},function(){
		var this_class = $(this).children("span").attr("class");
		$(this).children("span").removeClass(this_class);
		$(this).children("span").addClass(this_class.substring(0,this_class.length-6));
	});
//////////////////////////////////////////////////////////////////////
	$(".nav-icon").live("click",function(){
		if($(".nav-top").width()/$(".nav-icon").width() < 20 ){
			if($(".nav-left").position().top != 0){
				$.NavLeftShow();
			}else{
				$.NavLeftHide();
			}
		}
	});
	$(".host-item-tabs li").live("click",function(){
		$(".host-item-tabs li").removeClass("active");
		$(this).addClass("active");
		$(".main-item-single-host-item-tabs .host-mgmt-item").removeClass("hide");
		$(".main-item-single-host-item-tabs .host-mgmt-item").css("display","none");
		if($(this).hasClass("hostinfo")){
			$(".main-item-single-host-item-tabs .host-mgmt-item-hostinfo").css("display","block");
		}else if($(this).hasClass("logs")){
			$(".main-item-single-host-item-tabs .host-mgmt-item-logs").css("display","block");
		}else if($(this).hasClass("cookies")){
			$(".main-item-single-host-item-tabs .host-mgmt-item-cookies").css("display","block");
		}
	});
	$(".nav-left li").live("click",function(){
		window.location.href = $(this).children("a").attr("href");
	});
	$(".main-item-proj-add").live("click",function(){
		window.location.href = $(this).children(".proj-add").children("a").attr("href");
	});
	$("button.btn-checkall").live("click",function(){
		if($(this).attr("status") == "unchecked"){
			$(".main-item .s_checkbox").prop("checked", true);
			$(".projs-items .s_checkbox").prop("checked", true);
			$(this).attr("status", "checked");
		}else{
			$(".main-item .s_checkbox").prop("checked", false);
			$(".projs-items .s_checkbox").prop("checked",false);
			$(this).attr("status", "unchecked");
		}
	});
	$("button.btn-delete-item.del-module").live("click",function(){
		var id = "";
		$.each($(".main-item input.s_checkbox:checked"),function(index, item){
			id = id + " " + $(item).val();
		});
		if(id != ""){
			if(confirm("Are sure to delete the modules you select?\nID:" + id)){
				$.each($(".main-item input.s_checkbox:checked"),function(index, item){
					var url = $(item).closest(".main-item").children(".main-item-footer").children(".main-item-footer-operater").children("a.delete").attr("href");
					$.get(url);
					$(item).closest(".main-item").hide();
				});
			}
		}
	});
	$("button.btn-delete-item.del-projitem").live("click",function(){
		var id = "";
		$.each($(".projs-items input.s_checkbox:checked"),function(index, item){
			id = id + " " + $(item).val();
		});
		if(id != ""){
			if(confirm("Are sure to delete the items you select?\nID:" + id)){
				$.each($(".projs-items input.s_checkbox:checked"),function(index, item){
					var url = $(item).closest(".projs-items").children(".main-item-projs-footer").children(".main-item-projs-footer-operater").children("a.delete").attr("href");
					$.get(url);
				});
				window.location.reload();
			}
		}
	});
	$("button.btn-delete-item.del-hostip").live("click",function(){
		var id = "";
		$.each($(".main-item-host input.s_checkbox:checked"),function(index, item){
			id = id + "[" + $(item).val() + "] ";
		});
		if(id != "["){
			if(confirm("Are sure to delete the hosts you select?\nIP:" + id)){
				$.each($(".main-item-host input.s_checkbox:checked"),function(index, item){
					var url = $(item).closest(".main-item-host").children(".main-item-footer").children(".main-item-footer-operater").children("a.delete").attr("href");
					$.get(url);
				});
				window.location.reload();
			}
		}
	});
	$(".main-item-single-addproj-module .module-item").live("click",function(){
		if(!$(this).hasClass("selected")){
			if($(this).attr("only") == "1"){
				if(!confirm("You select a module has only tag, it will unchecked other selected modules, are sure to do that? ")){
					return false;
				}
				$.each($(".main-item-single-addproj-module .module-item.selected"),function(index, mod_item){
					$(mod_item).click();
				});
			}
			var isHasOnly = 0;
			var onlyInfo = "";
			$.each($(".main-item-single-addproj-module .module-item.selected"),function(index, mod_item){
				if($(mod_item).attr("only") == "1"){
					isHasOnly = 1;
					onlyInfo = $(mod_item).children("a").children("span.name").text();
				}
			});
			if(isHasOnly == 1){
				alert("You have selected item \"" + onlyInfo + "\" which had only limit");
				return false;
			}
				
			$.loadModConfigHtml($(this));
			$(this).addClass("selected");
		}else{
			$.removeModConfigHtml($(this));
			$(this).removeClass("selected");
		}
	});
	$(".main-item-projs-body span.info").live("click",function(){
		window.location.href = $(this).attr("href");
	});
	$(".i8987777666").live("mouseover", function(){
		if($(".proj-mod-configure span._"+$(this).attr("name")).length > 0) {
			$(this).val($(".proj-mod-configure span._"+$(this).attr("name")).attr("val"));
			$(".proj-mod-configure span._"+$(this).attr("name")).remove();
		}
	});
	$(".main-item-host .main-item-body .location").live("mouseover",function(){
		$.getIPLocation($(this));
	});
	$(".host-mgmt-item-hostinfo select").change(function(){
		window.location.href =  $(this).children("option:selected").attr("href");
	});
	$(".main-item-hosts-item .host-mgmt-commands .command button").live("click", function(){
		$(this).attr("disabled", true);
		var command = $(".main-item-hosts-item .host-mgmt-commands .command #inputCommand").val();
		var url = $(".main-item-hosts-item .host-mgmt-commands .command input[name='addcommandurl']").val();
		if(command == ""){
			$(this).attr("disabled", false);
			alert("Command couldn't be empty.");
			return false;
		}
		$.ajax({
			type:'POST',
			url: url,
			dataType:'json',
			data:{
				"type": "normal",
				"command": command
			},
			success:function(data){
				if(data.status == 0)
					alert(data.msg);
				else{
					alert("Success");
					$(".main-item-hosts-item .host-mgmt-commands .command #inputCommand").val("");
				}
			},
			error:function(){
				console.log("Error: Fail to reach the url.");
			}
		});
		$(this).attr("disabled", false);
	});
	$(".host-mgmt-item-module .module-item").live("click", function(){
		$(this).attr("disabled", false);
		$("#modal-config-module .modal-body form").html("");
		var mid = $(this).attr("id");
		$.ajax({
			type:'POST',
			url: $(this).attr("url"),
			dataType:'json',
			success:function(data){
				if(data.status == 1){
					if(data.data != ""){
						$.each(data.data, function(index, data_item){
							var name = data_item[0];
							var desc = data_item[1] ;
							var html = "<div class=\"form-group form-group-mod-" + mid + "\"><label for=\"inputTitle\" class=\"col-sm-2 control-label\">" + escapeHtml(name) + "</label><div class=\"col-sm-9\"><input type=\"text\" name=\"" + escapeHtml(name) + "\" class=\"form-control input-mod-config\" id=\"inputTitle\" placeholder=\"" + desc + "\" check-type=\"required\" required=\"\"></div></div>";
							$("#modal-config-module .modal-body form").append(html);
						});
						$("#modal-config-module .modal-body form").append("<input name=\"mid\" type=\"hidden\" value=\"" + mid + "\">");
						$("#modal-config-module").modal("show");
					}else{
						$("#modal-config-module .modal-body form").append("<input name=\"mid\" type=\"hidden\" value=\"" + mid + "\">");
						$("#modal-config-module .modal-footer button[type='submit']").click();
					}
				}else{
					alert(data.msg);
				}
			},
			error:function(){
				alert("Error: Fail to load the module configure.");
			}
		});
	});
	$("#modal-config-module .modal-footer button[type='submit']").live("click", function(){
		$(this).attr("disabled", true);
		var url = $(".main-item-hosts-item .host-mgmt-commands .command input[name='addcommandurl']").val();
		var data = new Array(0);
		var mid = $("#modal-config-module .modal-body form input[name='mid']").val();
		var cont = 1;
		$.each($("#modal-config-module .modal-body form input.input-mod-config"), function(index, item){
			if($(item).val() == ""){
				alert($(item).attr("name") + " couldn't be empty.");
				cont = 0;
				return;
			}
			data.push(new Array($(item).attr("name"), $(item).val()));
		});
		if(cont == 1){
			data = JSON.stringify(data);
			$.ajax({
				type:'POST',
				url: url,
				dataType:'json',
				data:{
					"type": "module",
					"mid": mid,
					"data": data
				},
				success:function(data){
					if(data.status == 0)
						alert(data.msg);
					else{
						alert("Success");
						$("#modal-config-module").modal("hide");
					}
				},
				error:function(){
					console.log("Error: Fail to reach the url.");
				}
			});
		}
		$(this).attr("disabled", false);
	});
////////////////////////////////////////////////////////////////////////
	var entityMap = {
		    "&": "&amp;",
		    "<": "&lt;",
		    ">": "&gt;",
		    '"': '&quot;',
		    "'": '&#39;',
		    "/": '&#x2F;'
		  };

		  function escapeHtml(string) {
		    return String(string).replace(/[&<>"'\/]/g, function (s) {
		      return entityMap[s];
		    });
		  }
	
	
	
	
});