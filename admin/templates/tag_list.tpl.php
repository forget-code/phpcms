<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<table cellpadding='2' cellspacing='1' border='0' align='center' class='tableBorder'>
  <tr>
    <td class='pagemenu'>
<?php
$i = 1;
foreach($modules as $m=>$name)
{
?>
     <a href="?mod=<?=$m?>&file=tag&action=manage" class='pagelink'><?=$name?></a>
<?php 
if($i%15==0) echo '<br/>'; else echo ' | ';
$i++;
}
?>
	</td>
  </tr>
</table>
<br/>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6>标签管理</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td class="tablerowhighlight" width="15%">标签名称</td>
<td class="tablerowhighlight" width="20%">站内标签调用</td>
<td class="tablerowhighlight" width="40%">跨站JS调用</td>
<td class="tablerowhighlight" width="10%">所属模块</td>
<td class="tablerowhighlight" width="15%">管理操作</td>
</tr>
<?php 
foreach($tags AS $tagname=>$tag)
{
	preg_match("/^(([a-z0-9]+)[_]*[a-z0-9]*)[(]/", $tag, $m);
	$function = $m[1];
	$mod = $m[2];
	$jscode = strpos($tag, '$') ? '无' : '&lt;script type=&#34;text/javascript&#34; src=&#34;'.$PHP_SITEURL.'js.php?tag='.urlencode($tagname).'&#34;>&lt;/script&gt;';
?>
<tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><?=$tagname?></td>
<td align="left">
<input type='text' value="{tag_<?=$tagname?>}" size='25' name='tag<?=$tagname?>a' title="提示：双击鼠标复制标签内容至剪贴板..." onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');"><br/>
</td>
<td align="left">
<input type='text' value="<?=$jscode?>" size='45' name='js<?=$tagname?>' title="提示：双击鼠标复制标签内容至剪贴板..." onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');">
</td>
<td align="center"><a href="?mod=<?=$mod?>&file=tag&action=manage&function=<?=$function?>"><?=$MODULE[$mod]['name']?></a></td>
<td><a href="?mod=<?=$mod?>&file=tag&action=preview&channelid=<?=$channelid?>&tagname=<?=urlencode($tagname)?>">预览</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&function=<?=$function?>&tagname=<?=urlencode($tagname)?>">修改</a> | <a href="###" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&tagname=<?=urlencode($tagname)?>&forward=<?=urlencode($PHP_URL)?>','确认删除此标签吗？如果您在模板中使用了短标签或JS调用，则请不要删除！')">删除</a></td>
</tr>
<?php 
}
?>
</table>
</form>
<br/>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align="center">提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
<strong>模板制作与标签调用的基本操作流程：</strong>
<p>
1、设计好html页面<br/>
2、根据页面布局插入站内调用标签<br/>
3、根据页面里的站内调用标签在后台填加标签并设置合适的参数<br/>
4、更新前台页面即可看到效果<br/>
	</td>
  </tr>
</table>
</body>
</html>