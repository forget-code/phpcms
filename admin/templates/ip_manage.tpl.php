<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?php echo $menu; ?>
<form name="formip" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add&dosubmit=1" >
  <table border="0" align="center" cellpadding="1" cellspacing="1" class="tableborder">
    <tr>
      <th colspan="2">添加禁止IP</th>
    </tr>
    <tr>
      <td height="30" align="center" valign="middle" class="tablerow">禁止此IP地址：
      <input name="userip" type="text" value="<?=$ip?>" size="20" maxlength="15" />
      &nbsp;有效期：
      <input name="day" type="text" value="<?=$day?>" size="5" maxlength="5" /> 天 
      <select name="selectdays" id="selectdays" onchange="day.value=this.value;">
        <?php
	  foreach(range(1,30) as $number)
	  {  
	   echo '<option value="'.$number.'"';
	   if($day==$number) echo ' selected="selected" ';
	   echo '>'.$number.'天</option>';
	  }
	  ?></select></td>
      <td class="tablerow">
	   &nbsp; <input name="submit" type="submit" value=" 添 加 " />
      &nbsp;(禁止ip段请使用123.34.*.* 这种形式)</td>
    </tr>
  </table>
</form>

<br />

<?php 
if($userips)
{
?>
<form name="myform" method="post" >

<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="9">IP列表管理</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight">选中</td>
<td class="tablerowhighlight">序号</td>
<td class="tablerowhighlight">IP</td>
<td class="tablerowhighlight">状态</td>
<td class="tablerowhighlight">过期时间</td>
<td class="tablerowhighlight">地理位置</td>
<td class="tablerowhighlight">操作者</td>
<td class="tablerowhighlight">管理操作</td>
</tr>
<?php 
	foreach($userips as $id=>$userip)
	{ 
	?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center">
<input type="checkbox" name="ipid[]" id="ipid<?php echo $userip['id']; ?>" value="<?php echo $userip['id']; ?>" /></td>
<td align="center" onMouseDown="document.getElementById('ipid<?php echo $userip['id']; ?>').checked = (document.getElementById('ipid<?php echo $userip['id']; ?>').checked ? false : true);"><?php echo $userip['id']; ?></td>
<td align="center" onMouseDown="document.getElementById('ipid<?php echo $userip['id']; ?>').checked = (document.getElementById('ipid<?php echo $userip['id']; ?>').checked ? false : true);">
<?php echo $userip['ip']; ?></td>
<td align="center" onMouseDown="document.getElementById('ipid<?php echo $userip['id']; ?>').checked = (document.getElementById('ipid<?php echo $userip['id']; ?>').checked ? false : true);" >
<?php if($userip['ifban']=='0') { ?><font color="green">允许</font><?php }else{ ?><font color="red">禁止</font><?php } ?></td>
<td align="center" onMouseDown="document.getElementById('ipid<?php echo $userip['id']; ?>').checked = (document.getElementById('ipid<?php echo $userip['id']; ?>').checked ? false : true);" ><?php echo $userip['overtime']; ?></td>
<td align="left" onMouseDown="document.getElementById('ipid<?php echo $userip['id']; ?>').checked = (document.getElementById('ipid<?php echo $userip['id']; ?>').checked ? false : true);">
<?php echo $userip['location']; ?></td>
<td align="center" onMouseDown="document.getElementById('ipid<?php echo $userip['id']; ?>').checked = (document.getElementById('ipid<?php echo $userip['id']; ?>').checked ? false : true);">
<a href='<?=PHPCMS_PATH?>member/member.php?username=<?=$userip['username']?>' target='_blank'><?php echo $userip['username']; ?></a></td>
<td align="center" onMouseDown="document.getElementById('ipid<?php echo $userip['id']; ?>').checked = (document.getElementById('ipid<?php echo $userip['id']; ?>').checked ? false : true);">
<?php if($userip['ifban']=='0'){ ?><a href="?mod=<?php echo $mod; ?>&amp;file=<?php echo $file; ?>&amp;action=banip&amp;ifban=1&amp;ipid=<?php echo $userip['id']; ?>" title="<?php $medicine['uip']?>">禁止访问</a> | <?php }else{ ?><a href="?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=banip&ifban=0&ipid=<?php echo $userip['id']; ?>" title="<?php $userip['ip']; ?>">允许访问</a> |<?php  } ?> <a href="?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=delete&ipid=<?php echo $userip['id']; ?>" >删除此记录</a></td>
</tr>
<?php }  ?>
</table>
<?php 
} else { ?>
<center>
  <strong>暂无信息</strong>
</center>
<?php } ?>
<?php 
if($userips)
{
?>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<input name='chkall' title="全部选中" type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox' />
	全选/不选
	<input name="delall" type="submit" id="delall" onClick="document.myform.action='?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=delete'" value=" 删 除 " /></td>
  </tr>
</table>
</form>
<?php 
}
?>

<div align="center">
  <?php if($number>$pagesize) echo $pages; ?>
</div>

<br />
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="1">搜索IP</th>
  </tr>
  <td class="tablerow" align="center">
  搜索IP：<input type="text" name="sip" maxlength="15" id="sip" value="<?=$sip?>" />&nbsp;&nbsp;
  操作者：<input type="text" name="username" maxlength="15" id="username" value="<?=$username?>" />&nbsp;&nbsp;
  <input type="submit" name="submit" value=" 搜 索 " onclick="self.location.href='?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=manage&sip='+ sip.value + '&username=' +username.value;"/>
  </td>
</table>

</body>
</html>