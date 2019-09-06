<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$PHPCMS['sitename']?>网站管理 - Powered by Phpcms <?=PHPCMS_VERSION?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8>">
<link rel="stylesheet" type="text/css" href="admin/skin/system.css"/>
<link rel="stylesheet" type="text/css" href="admin/skin/tree.css"/>
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="images/js/css.js"></script>
<script type="text/javascript" src="images/js/menu.js"></script>
<style>
body {
	width:100%;
	background:#ECF7FE url(admin/skin/images/bg_body.jpg) repeat-y top left;
	<?php
	if($PHPCMS[enablegetscrollbar])
	{
	?>
	scrollbar-face-color: #E7F5FE; 
	scrollbar-highlight-color: #006699; 
	scrollbar-shadow-color: #006699; 
	scrollbar-3dlight-color: #E7F5FE; 
	scrollbar-arrow-color: #006699; 
	scrollbar-track-color: #E7F5FE; 
	scrollbar-darkshadow-color: #E7F5FE; 
	scrollbar-base-color: #E7F5FE;
	<?php
	}
	?>
}
</style>

</head>
<body scroll="no">
<!--head-->
<div id="header">
  <div class="logo"><a href="<?=$PHPCMS['siteurl']?>" target="_blank"><img src="admin/skin/images/logo.jpg" width="220" height="58" border="0"/></a></div>
  <p id="info_bar"> 用户名：<strong class="font_arial white">
    <?=$_username?>
    </strong>，角色：
    <?php foreach($_roleid as $roleid) echo $ROLE[$roleid].' ';?>
    | <a href="?mod=phpcms&file=logout" class="white">退出登录</a> | <a href="<?=$PHPCMS['siteurl']?>" class="white" target="_blank">网站首页</a></p>
  <div id="menu">
    <ul>
      <?=menu(1, '<li><a href="javascript:get_menu($menuid, \'tree\', 0)" id="menu_$menuid" class="menu" alt="$name"><span>$name</span></a></li>')?>
    </ul>
  </div>
</div>
<div id="admin_left">
  <div id="inner" class="inner">
    <h4><em style="float:right"><img src="admin/skin/images/refresh.gif" onClick="javascript:menu_refresh()" width="16" height="25" id="menurefresh" alt="刷新" title="刷新" />
	<?php
	if(!$PHPCMS['enablegetscrollbar']) { ?>
	<img src="admin/skin/images/up.gif" id="up" width="19" height="23" border="0" alt="向上" /> <img src="admin/skin/images/down.gif" id="down" width="25" height="23" border="0" alt="向下" />
	<?php } ?>
	</em><span id="menu_name">我的面板</span></h4>
	<?php
	if($PHPCMS['enablegetscrollbar']) { ?>
    <div id="tree_box" class="p_r" style="top:10px; left:6px;" >
      <div id="tree" class="tree p_a" style="top:34px;overflow:auto;overflow-x:hidden;"></div>
    <?php
	}else{
	?>
	 <div id="tree_box" class="p_r" style="top:10px; left:8px;" >
      <div id="tree" class="tree p_a" style="top:34px;"></div>
	<?php
	}
	?>
	  <div id="tree_bg" class="p_a"></div>
      <div id="tree_click"  class="p_a"></div>
    </div>
  </div>
</div>
<div id="admin_right">
  <div id="inner" class="inner">
    <!--导航-->
    <span class="btn_menu">
		<?php
		if(isset($MODULE['message'])){?>
		<a href="<?=$MODULE['message']['url']?>" target="right"><img id="msg_img" src="admin/skin/images/icon_4.gif" title="短消息" height="22" width="22" /></a>
		<?php }?>
        <a href="javascript:show_map();show_div(this)" id="show_map" title="后台管理地图"><img src="admin/skin/images/icon_9.gif" title="后台管理地图" height="22" width="22" /></a>
        <a href="javascript:add_menu()" title="添加常用操作"><img src="admin/skin/images/icon_1.gif" title="添加常用操作" height="22" width="22" /></a>
		<a href="javascript:search_menu()"><img src="admin/skin/images/icon_2.gif" title="菜单搜索" height="22" width="22"  /></a>
		<a href="?mod=phpcms&file=safe&action=start" target="right" onclick="show_div(this)"><img src="admin/skin/images/icon_3.gif" title="扫描木马" height="22" width="22"  /></a>
		<a href="javascript:get_memo()" onclick="show_div('memo')"><img src="admin/skin/images/icon_7.gif" title="备忘录" height="22" width="22" /></a>
		<a href="javascript:help_url();show_div(this)"><img src="admin/skin/images/icon_6.gif" title="使用帮助，按F2也可以打开帮助" height="22" width="22"  /></a>
	</span>
	<input type="hidden" name="ismsgopen" id="ismsgopen" value="0" /> 
    <div id="new_msg"><img src="admin/skin/images/s.gif" alt="查看新消息" style="width:49px;height:20px;margin-right:-2px;" onclick="go_right('message/inbox.php?userid=<?php echo($_userid)?>');" /><img src="admin/skin/images/close_1.gif" alt="关闭" onclick="$('#new_msg').hide();$('#ismsgopen').val('1');" style="margin:5px 15px;" /></div>
    <div class="div" id="add_menu">
      <form action="" method="POST" onsubmit="return add_mymenu()">
        <div class="menu_line">菜单名称：
          <input type="text" name="menu_name" id="my_menu_name" size="40">
        </div>
        <div class="menu_line">菜单地址：
          <input type="text" name="menu_url" id="my_menu_url" size="40">
        </div>
        <div class="menu_line">
          <input type="submit" value="添加到常用操作" style="margin-left:60px;">
        </div>
      </form>
    </div>
	<div id="msg_div" class="div">
	<div class="content_i">
		<ul id="adminlist">
		</ul>
	<div class="footer">
		<div class="footer_left"></div>
		<div class="footer_right"></div>
		<div>
			<div class="btn"><a href="<?php echo($MODULE['message']['url'])?>outbox.php?userid=<?php echo($_userid)?>" target="right"><img src="admin/skin/images/btn_sjx.gif" width="54" height="24" /></a></div>
			<div class="btn"><a href="<?php echo($MODULE['message']['url'])?>inbox.php?userid=<?php echo($_userid)?>"  target="right"><img src="admin/skin/images/btn_fjx.gif" width="54" height="24" /></a></div>
		</div>
	</div>
	</div>
	</div>
    <div id="search_menu" class="div">
      <input type="text" name="menu_key" id="menu_key" value="请输入菜单名称" onblur="if($(this).val()=='')$(this).val('请输入菜单名称')" onfocus="if($(this).val()=='请输入菜单名称')$(this).val('')" size="30" />
      <div id="floor"></div>
    </div>
    <div id="memo" class="div">
	<div id="memo_mtime" style="text-align:right;padding-right:10px;"></div>
    <textarea id="memo_data" name="memo_data" rows="10" cols="50" style="padding:5px" onblur="set_memo(this.value)">
    </textarea>
    </div>
    <div id="position"><strong>后台首页：</strong><a href="javascript:get_menu(2,'tree',0);">我的面板</a></div>
    <div>
      <iframe name="right" id="right" frameborder="0" src="?mod=phpcms&file=index&action=main" style="height:100%;width:100%;z-index:111;background-color:#ffffff"></iframe>
    </div>
    <div class="help_line_top" onclick="help_url()" title="点击查看帮助"><img  id="help_line" src="admin/skin/images/top.gif" width="13" height="5" border="0" alt="在线帮助"/></div>
    <iframe name="help" id="help" frameborder="0" src="" style="height:0px;width:100%;z-index:111"></iframe>
  </div>
</div>
<div class="window_1" id="window_1">
  <div class="window_title"><img src="admin/skin/images/close.gif" alt="" height="16px" width="16px" onclick="$('.window_1').hide();$('.btn_menu').children('a').attr('class','');" class="jqmClose" style="cursor:pointer;float:right;"/>Phpcms网站后台导航地图
  </div>
  <div style="clear:both;" class="window_2">
<?php 
foreach($menu as $val){
	$topmenuid = $val['menuid'];
?>
    <dl>
      <dt><?php echo $val['name']?></dt>
      <?php foreach ($val['child'] as $v){?>
            <dd><span class="c_111">├</span><?php if($v['url']) echo "<a href='$v[url]' target='$v[target]' onclick=\"$('#position').load('?mod=phpcms&file=menu&action=menu_pos&menuid=$v[menuid]');get_menu($val[menuid], 'tree', 0);\">";?><?php echo $v['name']?><?php if($v['url']) echo "</a>";?></dd>
			  <?php if (isset($v['child']))foreach ($v['child'] as $vv){?>
				<dd><span class="c_111">│├</span><?php if($vv['url']){?><a href="<?php echo $vv['url']?>" target="<?php echo $vv['target']?>" onclick="javascript:click_topmenu(<?=$topmenuid?>);get_menu(<?php echo($vv['menuid'])?>, 'tree', 0);$('#position').load('?mod=phpcms&file=menu&action=menu_pos&menuid=<?php echo($vv['menuid'])?>');"><?php }?><?php echo $vv['name']?><?php if($vv['url']){?></a><?php }?></dd>
			  <?php }?>
      <?php }?>
    </dl>
<?php }?>
</div>
<script type="text/javascript" src="images/js/jqDnR.js"></script>
<script language="JavaScript">
var cut_nums = 0;
if(!$.browser.msie) cut_nums = 10;
var screen_h = parseInt(document.documentElement.clientHeight)-95-parseInt(cut_nums);
$("#tree").css("height",screen_h);

var site_url = 'admin/skin/';
get_menu(2,'tree',0);
$("#menu_2").addClass("selected");
window.onresize=function()
{
    var widths = document.body.scrollWidth-220;
    var heights = document.documentElement.clientHeight-98;
    $("#right").height(heights).width(widths);
    $("#admin_left").height((heights+28));
	$('.window_1').css('left', (widths + 380 - $('.window_1').width())+'px');
}

window.onresize();

var speed = 1;
var px = 5;
$('#down').mouseover(function(){tree_down();MyMar=setInterval(tree_down,speed);});
$('#up').mouseover(function(){tree_up();MyMar=setInterval(tree_up,speed);});
$('#down').mouseout(function(){clearInterval(MyMar)});
$('#up').mouseout(function(){clearInterval(MyMar)});
function tree_up()
{
	var inner_height = $("#admin_left").height()-50;
	var height = $("#tree").height();
	var top = (height-inner_height)+inner_height*0.5;
	var nowtop = parseInt($("#tree_box").css('top').replace('px',''));
	if(-top < nowtop)
	{
		if(height > inner_height)
		{
			$("#tree_box").css('top',(parseInt($("#tree_box").css('top').replace('px',''))-px)+'px');
		}
	}
}
function tree_down()
{
	var nowtop = parseInt($("#tree_box").css('top').replace('px',''));
	if(nowtop<0)
	{
		$("#tree_box").css('top',(parseInt($("#tree_box").css('top').replace('px',''))+px)+'px');
	}
}
function resetf5(event) {
		event = event ? event : window.event;
		keycode = event.keyCode ? event.keyCode : event.charCode;
		if(keycode == 116 || (event.ctrlKey && keycode==82)) {
			parent.right.location.reload();
			if(document.all) {
				event.keyCode = 0;
				event.returnValue = false;
			} else {
					event.cancelBubble = true;
					event.preventDefault();
			}
		}
		if(keycode==113)
		{
			help_url();
			if(document.all) {
					event.keyCode = 0;
					event.returnValue = false;
			} else {
					event.cancelBubble = true;
					event.preventDefault();
			}
		}
}
var height = 200;//帮助窗口展开的高度
function show_help(url)
{
	if($('#help').height()!=height)
	{
		$('#right').height($('#right').height()-height);
		$('#help').height(height);
		$('.help_line_top').attr('class','help_line_bottom');
		if(url!=$('#help').attr('src'))
		{
			$('#help').attr('src',url);
		}
		$('#help_line').attr('src','admin/skin/images/bottom.gif');
	}
	else
	{
		$('#right').height($('#right').height()+height);
		$('#help').height(0);
		$('.help_line_bottom').attr('class','help_line_top');
		$('#help_line').attr('src','admin/skin/images/top.gif');
	}
}

function help_url()
{
	var url = $('#right').attr('src');
	var mod = url.match(/mod=([A-Za-z]+)/i);
	if(mod){
		mod = mod[1];
	}
	else
	{
		mod = '';
	}
	var file = url.match(/file=([A-Za-z0-9_]+)/i);
	if(file){
		file = file[1];
	}
	else
	{
		file = '';
	}
	var action = url.match(/action=([A-Za-z0-9_]+)/i);
	if(action)
	{
		action = action[1];
	}
	else
	{
		action = '';
	}
	var url = '?mod=phpcms&file=help&module='+mod+'&files='+file+'&actions='+action;
	if(url!=$('#help').attr('src') && $('#help').attr('src')!='')
	{
			$('#help').attr('src',url);
			if($('#help').height()!=height)
			{
				$('#right').height($('#right').height()-height);
				$('#help').height(height);
			}
	}
	else
	{
		show_help(url);
	}
}

if(document.documentElement.addEventListener) {
	document.documentElement.addEventListener('keydown', resetf5, false);
} else if(document.documentElement.attachEvent) {
	document.documentElement.attachEvent("onkeydown", resetf5);
}

function add_menu()
{
	show_div('add_menu');
	$('#my_menu_url').val($('#right').attr('src'));
	$('#my_menu_name').val(right.document.title);
}

function add_mymenu()
{
	var name = $('#my_menu_name').val();
	var url = $("#my_menu_url").val();
	if (name=='')
	{
		alert('菜单名称不能为空');
		$("#my_menu_name").focus();
		return false;
	}
	if (url=='')
	{
		alert('菜单地址不能为空');
		$("#my_menu_url").focus();
		return false;
	}
	$.get("?mod=phpcms&file=menu&action=add_mymenu", {name: name, url: url},function(data){
		if(data == 1){alert('操作成功');}else {alert('操作失败');}
		add_menu();
	});
	return false;
}

function search_menu(){
	show_div('search_menu');
	$('#menu_key').phpcmstip('menu_key');
}


jQuery.fn.phpcmstip = function(option){
	$(this).keyup(function(){search_menu_key()})
}

function search_menu_key()
{
	var val = $('#menu_key').val();
	val = val.trim();
	if(val.length > 1)
	{
		$.getJSON('?mod=phpcms&file=menu&action=ajax_menu&time='+Math.random(), {menuname: val}, function(data){
		var divs = '';
		if(data){
		$.each(data, function(i, n){
		if(n.name!=''){
      	divs+="<div class=unselected_s onclick='show_div(\"search_menu\");click_menu(this)' onmouseout = $(this).attr('class','unselected_s') onmouseover = mouseover(this)><a href='"+n.url+"' target=\"right\">"+ n.name +"</a></div>";}
	});
		}
    $('#floor').html(divs);
    show_text()});
	}
}

String.prototype.trim = function()
{
    return this.replace(/(^\s*)|(\s*$)/g, "");
}

function show_text()
{
	$('#floor').width($("#menu_key").width() - 2);
}

function mouseover(sDiv)
{
    $("#floor").children("div").attr("class","unselected_s");
    $(sDiv).attr("class","selected_s");
}
var now_menu;
function show_div(obj)
{
	var arr = ['add_menu','search_menu','memo','msg_div'];

	$.each(arr,function(i,n){
		$("#"+n).slideUp("fast");
	});
	if(now_menu != obj)
	{
		$("#"+obj).slideDown("fast");
		now_menu = obj;
	}
	else
	{
		now_menu = '';
	}

}
function get_msg() 
{
	$.get('?mod=phpcms&file=index&action=get_msg&time='+Math.random(), function(data){
	if(data=='1') 
	{
		$('#msg_href').attr('href', 'go_right(\'message/inbox.php?userid=<?php echo($_userid)?>\')');
		$('#msg_img').attr('src', 'admin/skin/images/icon_8.gif');	
		if($('#ismsgopen').val() == 0)
		{
			$('#new_msg').show();
		}
	}
	else 
	{
		$('#msg_href').attr('href', 'javascript:show_admin_lists()');
		$('#msg_img').attr('src', 'admin/skin/images/icon_4.gif');
		$('#new_msg').hide();
	}
	})
}

$('.btn_menu').children('a').click(function(){
	click_menu(this);
});
function click_menu(obj)
{
	if($(obj).attr('class')=='btn_menu_hover')
	{
		$(obj).attr('class','');
	}
	else
	{
		$('.btn_menu').children('a').attr('class','');
		$(obj).attr('class','btn_menu_hover');
	}
}

function click_topmenu(id)
{
	$("#tree_click").hide();
	$("#tree_bg").hide();
	$("#menu_name").html($('#menu_'+id).attr('alt'));
	$(".menu").removeClass("selected");
	$('#menu_'+id).addClass("selected");
    get_menu(id, 'tree', 0);
}

function get_memo(){
	$.get('?mod=phpcms&file=memo&action=get', function(data){$('#memo_mtime').html(data.substring(0, 19));$('#memo_data').val(data.substring(19));});
}

function set_memo(data){
	$.post("?mod=phpcms&file=memo&action=set", { data: data }, function(data){$("#memo_mtime").html(data);});
}
function parent_file_list(obj)
{
	right.parent_file_list(obj);
}

function show_admin_lists() 
{
	show_div('msg_div');
	$.getJSON("?mod=phpcms&file=index&action=show_admin_list", function (data){
		if(data) 
		{
			var str = '';
			var first = 0;
			$.each(data, function (i, n) 
			{
				var classes = 'group_1';
				if(i=="1") 
				{
					classes = 'group_2';
				}
				str += '<li class="group"><div class="'+classes+'" onclick="admin_list(\'adminlist_'+i+'\',this)" width="24" height="24"></div> <a href="?mod=message&file=sendmessage_role&roleid='+i+'" target="right" title="群发短消息">'+n.name+'</a><font color="#cccccc">('+n.count+')</font></li>';
				if(n.users) 
				{
					$.each(n.users, function (s, d) 
					{
						var color = ' style="color:#cccccc"';
						var img = 'admin/skin/images/icon_gray.jpg';
						if(d.online==1) 
						{
							color = ' style="color:red"';
							img = 'admin/skin/images/icon_red.jpg';
						}
						var style = 'style="display:none;"';
						if(first == 0)
						{
							style = 'style="display:block;"';
						}
						str += '<li class="adminlist_'+i+'" '+style+'><img src="'+img+'"> <a href="<?php echo($MODULE['message']['url'])?>send.php?userid='+d.userid+'" target="right"'+color+'>'+d.username+'</a></li>';
					})
				}
				first = 1;
			});
			$("#adminlist").html(str);
		}
		else 
		{
			alert('网络出现问题，无法正常获得管理员列表。');
		}
	});
}

function admin_list(d,obj) 
{
	if($("."+d).css('display')!='none') 
	{
		obj.className = 'group_1';
	}
	else 
	{
		obj.className = 'group_2';
	}
	$("."+d).toggle();
}

function get_msg() 
{
	$.get('?mod=phpcms&file=index&action=get_msg&time='+Math.random(), function(data){
	if(data=='1') 
	{
		$('#msg_href').attr('href', 'javascript:show_admin_lists();go_right(\'message/inbox.php?userid=<?php echo($_userid)?>\')');
		$('#msg_img').attr('src', 'admin/skin/images/icon_8.gif');
		$('#new_msg').show();
	}
	else 
	{
		$('#msg_href').attr('href', 'javascript:show_admin_lists()');
		$('#msg_img').attr('src', 'admin/skin/images/icon_4.gif');
		$('#new_msg').hide();
	}
	})
}

function show_map() 
{
	$(".window_1").toggle();
}

function go_right(url) 
{
	$("#right").attr('src', url);
}
$('.window_1').jqDrag('.window_title');

setInterval(get_msg,10000);

<?php
if(isset($_SESSION['install_system']))
{
?>
show_map();
<?php
}
?>
</script>
</body>
</html>
