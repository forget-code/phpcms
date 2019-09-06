<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=9>频道管理</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">排序</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="10%" class="tablerowhighlight">频道名称</td>
<td width="5%" class="tablerowhighlight">类型</td>
<td width="5%" class="tablerowhighlight">模型</td>
<td width="5%" class="tablerowhighlight">访问</td>
<td width="5%" class="tablerowhighlight">状态</td>
<td width="*" class="tablerowhighlight">管理员</td>
<td width="23%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($channels)){
	foreach($channels as $channel){
?>
<tr align="center"  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input name="listorder[<?=$channel['channelid']?>]" type="text" size="2" value="<?=$channel['listorder']?>"></td>
<td><?=$channel['channelid']?></td>
<?php if(!$channel['islink']){?>
<td>
<a href="?mod=<?=$channel['module']?>&file=<?=$channel['module']?>&action=left&channelid=<?=$channel['channelid']?>" target="left"><span style="<?=$channel['style']?>"><?=$channel['channelname']?></span></a>
</td>
<td>内部</td>
<?php }else{ ?>
<td>
<a href="<?=linkurl($channel['linkurl'])?>" target="_blank"><span style="<?=$channel['style']?>"><?=$channel['channelname']?></span></a>
</td>
<td><font color="red">外部</font></td>
<?php } ?>
<td>
<?php if(!$channel['islink']){?>
<?=$MODULE[$channel['module']]['name']?>
<?php } ?>
</td>
<td><a href="<?=linkurl($channel['linkurl'])?>" target="_blank" >访问</a></td>
<td><?=$channel['status']?></td>
<td><?=$channel['admin']?></td>
<td align="left">
&nbsp;&nbsp;
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channel['channelid']?>">修改</a> | 
<?php if($channel['disabled']){?>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=disabled&value=0&channelid=<?=$channel['channelid']?>">启用</a>
<?php }else{ ?>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=disabled&value=1&channelid=<?=$channel['channelid']?>">禁用</a>
<?php } ?> | 
<a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&channelid=<?=$channel['channelid']?>','确认删除频道吗？此操作不可恢复！')">删除</a>
<?php if(!$channel['disabled'] && !$channel['islink']){?> | 
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=recreate&channelid=<?=$channel['channelid']?>">重建目录</a>
<?php } ?>
</td> 
</tr>
<?php 
	}
}
?>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td><input type="submit" name="dosubmit" value=" 排序 "></td>
  </tr>
</table>
</form>
<br/>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
<font color="red"><b>服务器操作系统为linux类的请注意：</b></font><br />
建立新的频道时，phpcms会在根目录下建立频道目录，而linux类系统默认情况下根目录不可写，因此会出现无法写入文件的错误。<br/>
<font color="blue">请通过以下两种方式正确建立新频道：</font><br/>
1、先用ftp建立好频道目录，然后把该目录设置为 777，再在后台添加频道。<br/>
2、进系统设置的基本配置设置好ftp并开启ftp功能，再在后台添加频道。<p>

<font color="blue">频道建立出错的解决办法：</font><br/>
1、通过ftp建立好频道目录并且把频道目录和子目录设置为 777<br/>
2、点该频道的“重建目录”链接即可
	</td>
  </tr>
</table>
</body>
</html>