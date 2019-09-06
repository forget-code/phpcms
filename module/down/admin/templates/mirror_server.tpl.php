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

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="8">镜像服务器管理</th>
  </tr>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&action=update">
<tr align="center">
<td width="50" class="tablerowhighlight">删除</td>
<td width="40" class="tablerowhighlight">ID</td>
<td width="50" class="tablerowhighlight">排序</td>
<td class="tablerowhighlight">地址</td>
<td width="100" class="tablerowhighlight">名称</td>
<td width="120" class="tablerowhighlight">LOGO</td>
<td width="120" class="tablerowhighlight">显示</td>
<td width="40" class="tablerowhighlight">锁定</td>
</tr>
<?php 
if(is_array($servers)){
	foreach($servers as $server){
?>
<tr align="center"  align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor="#F1F3F5">
<td><input name="sid[]" type="checkbox" value="<?=$server['sid']?>"></td>

<td><?=$server['sid']?></td>

<td><input size="4" name="listorder[<?=$server['sid']?>]" type="text" value="<?=$server['listorder']?>" <?php if($server['islock']) { ?>style="color:#cccccc;"<?php } ?>></td>

<td><input size="25" name="url[<?=$server['sid']?>]" type="text" value="<?=$server['url']?>" <?php if($server['islock']) { ?>style="color:#cccccc;"<?php } ?>></td>

<td><input size="15" name="name[<?=$server['sid']?>]" type="text" value="<?=$server['name']?>" <?php if($server['islock']) { ?>style="color:#cccccc;"<?php } ?>></td>

<td><input size="20" name="logo[<?=$server['sid']?>]" type="text" value="<?=$server['logo']?>" <?php if($server['islock']) { ?>style="color:#cccccc;"<?php } ?>></td>

<td><input type="radio" name="showtype[<?=$server['sid']?>]" value="0" <?php if(!$server['showtype']) { ?>checked <?php } ?>>名称 <input type="radio" name="showtype[<?=$server['sid']?>]" value="1" <?php if($server['showtype']) { ?>checked <?php } ?>>LOGO</td>

<td><input name="islock[<?=$server['sid']?>]" type="checkbox" value="1" <?php if($server['islock']) { ?> checked <?php } ?>></td>

</tr>
<?php 
	}
}
?>
</table>


<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="175"  align="center">
<input name="chkall" type="checkbox" id="chkall" onclick="checkall(this.form)" value="checkbox">全部选中
</td>
<td>&nbsp;&nbsp;
<input type="submit" name="submit" value=" 更新镜像服务器信息 ">&nbsp;&nbsp;
<input type="submit" name="submit1"  value=" 删除选中镜像服务器 " onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&channelid=<?=$channelid?>'" >
</td>
</tr>
</table>
</form>

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
<tr align="center">
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&action=add">
<td class="tablerow">
服务器地址：<input name="url" type="text" size="25" title="必须以 / 结尾">&nbsp;名称：<input name="name" type="text" size="15">&nbsp;LOGO：<input name="logo" type="text" size="20"> <input type="radio" name="showtype" value="0" checked> 显示名称 <input type="radio" name="showtype" value="1"> 显示LOGO
<input name="submit" type="submit" value=" 添加 ">
</td>
</form>
</tr>
</table>

</body>
</html>