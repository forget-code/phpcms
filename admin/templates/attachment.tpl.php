<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=delete">
<input type="hidden" name="keyid" value="<?=$keyid?>" />
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="9"><?=$keyname?>附件管理</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight">删除</td>
<td class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">模块/频道</td>
<td class="tablerowhighlight">栏目</td>
<td class="tablerowhighlight">文件名</td>
<td class="tablerowhighlight">大小</td>
<td class="tablerowhighlight">上传时间</td>
<td class="tablerowhighlight">用户名</td>
<td class="tablerowhighlight">原文</td>
</tr>
<?php 
	foreach($atts as $id=>$att)
	{ 
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td align="center"><input type="checkbox" name="aid[<?=$id?>]" value="<?=$id?>" /></td>
<td align="center"><?=$id?></td>
<td align="center"><a href="<?=$att['keyurl']?>" target="_blank"><?=$att['keyname']?></a></td>
<td align="center"><a href="<?=$att['cat']['linkurl']?>" target="_blank"><?=$att['cat']['catname']?></a></td>
<td align="center"><a href="<?=linkurl($att['fileurl'])?>" target="_blank"><?=basename($att['fileurl'])?></a></td>
<td align="center"><?=bytes2x($att['filesize'])?></td>
<td align="center"><?=date('Y-m-d h:i:s',$att['addtime'])?></td>
<td align="center"><a href="?mod=member&file=member&action=view&username<?=$att['username']?>" target="_blank"><?=$att['username']?></a></td>
<td align="center"><a href="<?=itemurl($att['keyid'], $att['itemid'])?>" target="_blank">原文</a></td>
</tr>
<?php 
	}
?>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%">
	<input name='chkall' title="全部选中" type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox' /> 全选/不选
	</td>
	<td>
	<input name="dosubmit" type="submit" value=" 删除 " />
	</td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><?=$pages?></td>
  </tr>
</table>

</form>

</body>
</html>