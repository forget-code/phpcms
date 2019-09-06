var refresh = 0;
var menuid = 0;
function evet(){
	$(".tree_div").mouseover(function(){
		$("#tree_bg").show();
		var offset = $(this).offset();
		var offset3 = $("#tree_box").offset();
		var y = offset.top - offset3.top+2;
		$("#tree_bg").css({"top":y+'px',"*top":(y+2)+'px'});
	});
	$(".tree_div").mouseout(function(){$("#tree_bg").hide();});
	$(".tree_div").click(function(){
		$("#tree_bj").css("height","0px");
		$("#tree_bg").hide();
		var offset = $(this).offset();
		var offset3 = $("#tree_box").offset();
		var y = offset.top - offset3.top+2;
		$("#tree_click").show();
		$("#tree_click").css("top",y+"px");
	});
}

$(document).ready(function(){
	$(".menu").click(function(){
	$("#tree_click").hide();
	$("#tree_bg").hide();
	$("#menu_name").html($(this).attr('alt'));
	$(".menu").removeClass("selected");
	$(this).addClass("selected");});
});

function get_menu(id,obj,islen){
	if(islen==0)
	{
		$("#tree_box").css('top', 0);
	}
	if (islen==0)
	{
		menuid = id;
	}
	$('#position').load('?mod=phpcms&file=menu&action=menu_pos&menuid='+id);
	$("#"+obj).html('<img src="'+site_url+'images/loading.gif" width="16" height="16" border="0" />');
	var touimg_src = '';
	var img_src = '';
	var mleft = 's';
	var regexp = /(.*)images\/elbow-end-plus/;
	if ($("#tree_"+id).css("display")=='none'){
		if (regexp.test($("#touimg_"+id).attr("src")))
		{
			touimg_src = 'elbow-end-minus.gif';
			mleft = 'ss';
		}else{
			touimg_src = 'elbow-minus.gif';
		}
		img_src = "folder-open.gif";
		$("#tree_"+id).show();
	}else{
		if (regexp.test($("#touimg_"+id).attr("src")))
		{
			touimg_src = 'elbow-end-plus.gif';
		}else{
			touimg_src = 'elbow-plus.gif';
		}
		img_src = "folder.gif";
		$("#tree_"+id).hide();
	}
	$("#touimg_"+id).attr('src',site_url+'images/'+touimg_src);
	$("#img_"+id).attr('src',site_url+'images/'+img_src);
	
	var cache_refresh = refresh ? 'false': 'true';
	$.ajax({type:'get', url:'?mod=phpcms&file=menu&action=get_menu_list&menuid='+id, cache:cache_refresh,dataType:'json', success:function(json){
	var htmls="";
	var isend ="tree_line";
	var open = new Array();
	var openmenuids = ['99','120','130','300','360'];//默认要展开的menuid
	$.each(json,function(i,n){
		if (json.max != null && n.name != undefined)
		{
			var click,img,touimg='';
			if(n.isfolder==1){
				if($.inArray(n.menuid,openmenuids)>=0)
				{
					open[i] = n.menuid;
				}
				img = "folder.gif";
				click = " get_menu("+n.menuid+",'tree_"+n.menuid+"',"+(islen+1)+");";
				if(n.url !== '') click += 'document.getElementById(\''+n.target+'\').src=\''+n.url+'\';';
				if(n.menuid == json.max){
					touimg = "elbow-end-plus.gif";
					isend = "end";
				}else{
					touimg = "elbow-plus.gif";
				}
			}else{
				img = "leaf.gif";
				click = 'document.getElementById(\''+n.target+'\').src=\''+n.url+'\';';
				if (n.menuid == json.max)
				{
					touimg = 'elbow-end.gif';
				}else{
					touimg = 'elbow.gif';
				}
			}
			htmls += "<div class='tree_div' onclick=\""+click+"$('#position').load('?mod=phpcms&file=menu&action=menu_pos&menuid="+n.menuid+"');\" id='tree_div_"+n.menuid+"'>";
			var width = islen*16;
			htmls += '<span class="tree_img"><img src="'+site_url+'images/'+touimg+'" id="touimg_'+n.menuid+'" width="16" height="18" border="0" /><img src="'+site_url+'images/'+img+'" id="img_'+n.menuid+'" width="16" height="16" border="0" /></span><span class="tree_text">'+n.name+'</span></div>';
			if(n.isfolder==1){htmls +='<div id="tree_'+n.menuid+'" class="'+isend+'" style="display:none;"></div>';}
		}
	});
	if (htmls)
	{
		$("#"+obj).html(htmls);
	}else{
		$("#tree_"+id).hide();
	}
	if(open)
	{
	$.each(open,function(i,n){get_menu(n,'tree_'+n,1)});
	}
	evet();
	}});
}

function menu_refresh()
{
	if (refresh==1)
	{
		refresh = 0;
		$('#menurefresh').attr('title', '点击设置为刷新状态');
		$('#menurefresh').attr('alt', '点击设置为刷新状态');
		$('#menurefresh').attr('src', 'admin/skin/images/refresh.gif');
	}
	else
	{
		refresh = 1;
		$('#menurefresh').attr('title', '点击设置为缓存状态');
		$('#menurefresh').attr('alt', '点击设置为缓存状态');
		$('#menurefresh').attr('src', 'admin/skin/images/refreshed.gif');		
		get_menu(menuid, 'tree', 0);
		setTimeout(menu_refresh, 30000);	
	}
}