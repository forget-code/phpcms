<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<?php if(isset($_grade) && $_grade==0){ ?>
<table cellpadding='2' cellspacing='1' border='0' align='center' class='tableBorder'>
  <tr>
    <td class='pagemenu'>
<?php
$i = 1;
foreach($modules as $m=>$name)
{
?>
		<a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&module=<?=$m?>&projectid=<?=$project?>" class='pagelink'><?=$name?></a>
<?php 
if($i%15==0) echo '<br/>'; else echo ' | ';
$i++;
}
?>
	</td>
  </tr>
</table>
<?php } ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td>当前位置：<a href="?mod=phpcms&file=templateproject&action=manage">模板方案管理</a> > <a href="?mod=phpcms&file=template&action=manage&project=<?=$project?>&module=<?=$module?>"><?=$projectname?> - <?=$MODULE[$module]['name']?> 模板管理</a></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>模板管理</th>
  </tr>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=update&module=<?=$module?>">
<tr align="center">
<td width="15%" class="tablerowhighlight">模板名称</td>
<td width="20%" class="tablerowhighlight">文件名</td>
<td width="15%" class="tablerowhighlight">模板类型</td>
<td width="30%" class="tablerowhighlight">调用标签</td>
<td width="5%" class="tablerowhighlight">默认</td>
<td width="15%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($templates)){
	foreach($templates as $template){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="text" name="templatename[<?=$template['file']?>]" size="17" value="<?=$template['name']?>"></td>
<td align="left"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channelid?>&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>" title="上次修改时间：<?=date("Y-m-d H:i:s",$template['mtime'])?>"><?=$template['file']?></a></td>
<td align="left"><?=$template['type']?></td>
<td><input type="text" name="function<?=$template['template']?>" size="35" value="{template '<?=$module?>','<?=$template['template']?>'}" onfocus="document.myform.elements['function<?=$template['template']?>'].select();"></td>
<td><?php if($template['isdefault']){?>√<?php }?></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&channelid=<?=$channelid?>&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>" title="上次修改时间：<?=date("Y-m-d H:i:s",$template['mtime'])?>">下载</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channelid?>&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>" title="上次修改时间：<?=date("Y-m-d H:i:s",$template['mtime'])?>">修改</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&channelid=<?=$channelid?>&template=<?=$template['template']?>&module=<?=$module?>&project=<?=$project?>" title="上次修改时间：<?=date("Y-m-d H:i:s",$template['mtime'])?>">删除</a></td>
</tr>
<?php 
	}
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">&nbsp;&nbsp;<input type="submit" name="submit" value=" 更新模板名称 "></td>
  </tr>
</table>
</form>
<br/>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	1、当前模板保存在 <font color="red">./templates/<?=$project?>/<?=$module?>/</font>  目录下（如果需要在线修改，请通过ftp将 ./templates/ 目录设置为 777 ，并应用到子目录）<br/>
	2、同类型模板具有相同的前缀，后面以中划线隔开。例如：<br/> tag_slidespecial.html 和 tag_slidespecial-js.html 都是 tag_slidespecial 类型的模板，并且 tag_slidespecial.html 是该类型的默认模板
	</td>
  </tr>
</table>
</body>
</html>