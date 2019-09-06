<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<div id="picPreview" style="position: absolute; z-index:2"></div>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>查询条件</caption>
   <tr>
    <td>上传者：<?=form::text('username','',$username,'',10);?></td>
	<td>模块：<?=form::text('module','',$module,'',10);?></td>
	<td>栏目：<?=form::select_category();?></td>
	<td>内容编号：<?=form::text('contentid','',$contentid,'',8);?></td>
	<td>排序：
	<select name='listorderby' id='listorderby' >
	<option value='aid'>aid</option>
	<option value='listorder' >listorder</option>
	<option value='downloads' >downloads</option>
	</select>
	</td>
	<td><input type="submit" name="dosubmit" value="查询"></td>
  </tr>
</table>
</form>

<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=delete">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>附件管理</caption>
    <tr>
        <th width="5%">删除</th>
        <th width="5%">ID</th>
        <th width="10%">模块</th>
        <th width="10%">栏目</th>
        <th>文件名</th>
        <th width="10%">大小</th>
        <th width="20%">上传时间</th>
        <th width="10%">用户名</th>
        <th width="10%">原文</th>
    </tr>
<?php 
	foreach($atts as $id=>$att)
	{ 
?>
    <tr> 
        <td class="align_c"><input type="checkbox" name="aid[<?=$att['aid']?>]" value="<?=$att['aid']?>" /></td>
        <td class="align_c"><?=$att['aid']?></td>
        <td class="align_c"><?=$att['module']?></a></td>
        <td class="align_c"><a href="<?=$CATEGORY[$att['catid']]['url']?>"><?=$CATEGORY[$att['catid']]['catname']?></a></td>
        <td align="left"><a href='#' 
        <?php
            if(isimage("$att[fileext]")){
                echo "onmouseover=\"show('".$att['filepath']."')\"";
                echo " onmouseout=\"hide(this)\"";
            }
        ?>
        ><?=$att['filename']?></a></td>
        <td><?=$a->size($att['filesize'])?></td>
        <td class="align_c"><?=date('Y-m-d h:i:s', $att['uploadtime'])?></td>
        <td class="align_c"><a href="<?=member_view_url($att['userid'])?>"><?=username($att['userid'])?></a></td>
        <td class="align_c"><a href="<?=content_url($att['contentid'])?>">原文</a></td>
    </tr>
<?php 
	}
?>
</table>
<div class="button_box"><a href="###" onClick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="###" onClick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a> 	<input name="dosubmit" type="submit" value=" 删除 " /></div>
<div id="pages"><?=$a->pages?></div>

<script type="text/javascript">
function show(imgurl) { 
    document.getElementById("picPreview").innerHTML = "<img src='" + imgurl + "' width=240>"; 
} 
function hide(_this) { 
    document.getElementById("picPreview").innerHTML = ""; 
} 
function move_layer(event){ 
    event = event || window.event; 
    document.getElementById("picPreview").style.left=event.clientX+document.body.scrollLeft+10; 
    document.getElementById("picPreview").style.top=event.clientY+document.body.scrollTop+10; 
} 
document.onmousemove =move_layer; 
</script>
</form>

</body>
</html>