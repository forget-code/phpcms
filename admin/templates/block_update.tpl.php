<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/jqModal.js"></script>
<script type="text/javascript" src="images/js/jqDnR.js"></script>
<body>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
<input type="hidden" name="forward" value="<?=$forward?>"> 
<input type="hidden" name="blockid" value="<?=$blockid?>"> 
<input type="hidden" name="blockname" value="<?=$name?>"> 
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption><?=$name?></caption>
<?php 
if($isarray)
{
	if(!isset($rows)) $rows = 8;
?>
<tr> 
  <th width="10" id="th_id">ID</th>
  <th width="*" id="th_title">标题</th>
  <th width="200" id="th_url">链接</th>
  <th width="150" id="th_thumb">缩略图</th>
  <th width="70" id="th_date">日期</th>
  <th width="200" id="th_description">摘要</th>
</tr>
<?php 
for($i = 0; $i < $rows; $i++){	
?>
<tr>
  <td width="10"><?=($i+1)?></td>
  <td width="*"><input type="text" name="data[<?=$i?>][title]" id="title_<?=$i?>" d="<?=$i?>" value="<?=htmlspecialchars(stripslashes($data[$i]['title']))?>" style="width:100%"></td>
  <td width="200" class="align_c"><input type="text" name="data[<?=$i?>][url]" id="url_<?=$i?>" value="<?=$data[$i]['url']?>" size="30"></td>
  <td width="150"><input type="text" name="data[<?=$i?>][thumb]" id="thumb_<?=$i?>" size="15" value="<?=$data[$i]['thumb']?>"> <input name="thumb_<?=$i?>_aid" id="thumb_<?=$i?>_aid" type="hidden"><input type="button" name="thumb_upimage" value="上传" style="width:40px" onclick="javascript:openwinx('?mod=phpcms&file=upload&uploadtext=thumb_<?=$i?>','upload','450','350')"/></td>
  <td width="70"><input type="text" name="data[<?=$i?>][date]" id="date_<?=$i?>" value="<?=$data[$i]['date']?>" size="10"></td>
  <td width="200"><textarea name="data[<?=$i?>][description]" id="description_<?=$i?>" style="width:100%;height:45px;"><?=$data[$i]['description']?></textarea></td>
</tr>
<?php } ?>
<?php 
}else{	
?>
<tr> 
  <td>
   <textarea name="data" id="data" style="width:100%;height:200px;padding:3px"><?=$data?></textarea>
   <?=form::editor('data', 'introduce', '100%', '300')?>
  </td>
</tr>
<?php 
}	
?>
</table>
<?php if($isarray){ ?>
<table cellpadding="0" cellspacing="1" id="edit_template" class="table_form" style="display:<?=$template ? 'none' : ''?>">
    <caption>模板代码</caption>
	<tr> 
	  <td width="80%" class="align_c"><textarea name="template" id="template" style="width:100%;height:120px;"><?php if($template){ echo $template; }else{ ?><h4>{$name}</h4>
<ul>
{loop $data $n $r}
   <li><a href="{$r[url]}">{str_cut($r[title], 40)} {$r[date]}</a></li>
{/loop}
</ul>
<?php } ?></textarea></td>
    <td class="align_c">
	<span style="height:25px"><input type="button" value="{loop *}" title="点击插入" style="width:60px" onClick="javascript:insertText('{loop $data $n $r}')" /></span>
	<span style="height:25px"><input type="button" value="{/loop}" title="点击插入" style="width:60px" onClick="javascript:insertText('{/loop}')" /></span><br />
	<span style="height:25px"><input type="button" value="碎片名称" title="点击插入" style="width:60px" onClick="javascript:insertText('{$name}')" /></span>
	<span style="height:25px"><input type="button" value="标题" title="点击插入" style="width:60px" onClick="javascript:insertText('{$r[title]}')" /></span><br />
	<span style="height:25px"><input type="button" value="URL" title="点击插入" style="width:60px" onClick="javascript:insertText('{$r[url]}')" /></span>
	<span style="height:25px"><input type="button" value="缩略图" title="点击插入" style="width:60px" onClick="javascript:insertText('{$r[thumb]}')" /></span><br />
	<span style="height:25px"><input type="button" value="日期" title="点击插入" style="width:60px" onClick="javascript:insertText('{$r[date]}')" /></span>
	<span style="height:25px"><input type="button" value="简介" title="点击插入" style="width:60px" onClick="javascript:insertText('{$r[description]}')" /></span>
	</td>
	</tr>
</table>
<?php } ?>
<div class="button_box" style="text-align:center">
<input type="submit" name="dosubmit" value="更新碎片">&nbsp;&nbsp;
<input type="button" value="搜索内容" class="jqModal" style="color:red">&nbsp;&nbsp;
<?php if($isarray){ ?>
<input type="button" value="修改模板" onclick="$('#edit_template').show()">&nbsp;&nbsp;
<?php } ?>
<input type="reset" name="reset" value="重置">
</div>
</form>
<table cellpadding="2" cellspacing="1" class="table_list">
    <caption><?=$name?> 碎片操作日志</caption>
<tr> 
  <th width="20%">操作时间</th>
  <th>操作</th>
  <th>操作人</th>
  <th>IP</th>
  <th>恢复数据</th>
</tr>
<?php foreach($logs as $logid=>$r)
{
?>
<tr> 
  <td class="align_c"><?=$r['time']?></td>
  <td class="align_c"><?=$actions[$r['action']]?></td>
  <td class="align_c"><a href="<?=member_view_url($r['userid'])?>"><?=$r['username']?></a></td>
  <td class="align_c"><a href="<?=ip_url($r['ip'])?>"><?=$r['ip']?></a></td>
  <td class="align_c"><a href="###" onclick="restoredata('?mod=<?=$mod?>&file=<?=$file?>&action=restore&blockid=<?=$blockid?>&logid=<?=$logid?>', <?=$isarray?>)">恢复</a></td>
</tr>
<?php } ?>
</table>
<div class="jqmWindow">
<h5 class="title" style="cursor:move"><a href="#" class="jqmClose"><img src="images/close.gif" alt="" height="16px" width="16px" /></a>搜索内容</h5>
<div id="protocol" style="height:400px;overflow:auto;">
<table cellpadding="0" cellspacing="0">
  <tr>
    <th width="80">栏目：</th>
    <td><span id="reselect_catid">  
<input type="hidden" name="catid" id="catid" value="">
<span id="load_catid"></span> 
<a href="javascript:category_reload();">重选</a>
</span></td>
  </tr>
  <tr>
    <th>关建词：</th>
    <td><input type="text" name="keyword" id="keyword"></td>
  </tr>
  <tr>
  <tr>
    <th>起始日期：</th>
    <td><input type="text" name="starttime" id="starttime" value="" size="10"> 格式：<?=date('Y-m-01')?></td>
  </tr>
  <tr>
    <th>结束日期：</th>
    <td><input type="text" name="stoptimee" id="stoptime" value="" size="10"> 格式：<?=date('Y-m-d')?></td>
  </tr>
  <tr>
    <th>显示数量：</th>
    <td><input type="text" name="rows" id="rows" value="50" size="10"> 条</td>
  </tr>
  <tr>
    <th></th>
    <td><input type="button" name="serach" value=" 搜索 " onclick="search()"> <?php if($isarray){ ?> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value=" 插入 " onclick="getin()" id="get_in"> <?php } ?> <div id="show_list" style="overflow:hidden;"></div> </td>
  </tr>
</table>
</div>
</div>
<script type="text/javascript">
$().ready(function(){
	$('.jqmWindow').jqm({overlay: 0	}).jqDrag('.title');
	$('form').checkForm(1);
});
function restoredata(url, isarray)
{
	if(isarray == 1)
	{
		$.getJSON(url, function(json){
			$.each(json, function(i, n){
                $('#title_'+i).val(n.title);
                $('#url_'+i).val(n.url);
                $('#thumb_'+i).val(n.thumb);
                $('#date_'+i).val(n.date);
                $('#description_'+i).val(n.description);
			});
		});
	}
	else
	{
		$.get(url, function(data){ FCKeditorAPI.GetInstance('data').SetHTML(data);} );
	}
}
function dopreview()
{
	myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=preview';
	myform.target='preview';
    myform.submit();
	myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>';
	myform.target='_self';
	return true;
}
function loadwindow()
{
	window.document.getElementById('preview').height = window.frames["preview"].document.body.scrollHeight +20;
	window.document.getElementById('preview').width = window.frames["preview"].document.body.scrollWidth;
}
function FCKeditor_OnComplete(editorInstance)
{
	editorInstance.SwitchEditMode();
}
function insertText(text)
{
	myform.template.focus();
    var str = document.selection.createRange();
	str.text = text;
}
function category_load(id)
{
	$.get('load.php', { field: 'catid', id: id },
		  function(data){
			$('#load_catid').append(data);
		  });
}
function category_reload()
{
	$('#load_catid').html('');
	category_load(0);
}
category_load(0);
var page = 0;
$('#keyword').blur(function(){
search();
});

function search()
{
	$.getJSON('?mod=phpcms&file=block&action=block_search', {keyword: $('#keyword').val(), catid: $('#catid').val(), page: page, starttime: $('#starttime').val(), stoptime: $('#stoptime').val(), rows: $('#rows').val()}, function(data){
		var str = '';
		if(data)
		{
			$.each(data,function(i,n){
				str += '<div id="list_'+i+'"><?php if($isarray){ ?><input type="checkbox" name="id[]" id="id_'+i+'" value="'+n.title+'|*|'+n.url+'|*|'+n.thumb+'|*|'+n.inputtime+'|*|'+n.description+'" style="border:0px"> <?php }else{ ?>·<?php } ?><a href="'+n.url+'" target="_blank">'+n.title+'</a> '+(n.thumb ? '<a href="'+n.thumb+'" target="_blank"><font color="red">图</font></a>' : '')+' '+n.inputtime+''
			});
		}
		else
		{
			str = '没有找到数据';
		}
		$("#show_list").html(str);
    });
}

function getin()
{
	$("input:checked").each(function(){
		var val = $(this).val();
		var vals = val.split('|*|');
		if(vals[0]!=1)
		{
			$("input[type='text'][name*='[title]']").each(function(){
				if($(this).val()=='')
				{
					var id = $(this).attr('d');
					$('#title_'+id).val(vals[0]);
					if(vals[1])$('#url_'+id).val(vals[1]);
					if(vals[2])$('#thumb_'+id).val(vals[2]);
					if(vals[3])$('#date_'+id).val(vals[3]);
					if(vals[4])$('#description_'+id).val(vals[4]);
					return false;
				}
			});
		}
	});
}
</script>
</body>
</html>