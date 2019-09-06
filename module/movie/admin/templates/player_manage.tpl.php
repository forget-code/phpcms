<?php defined("IN_PHPCMS") or exit("Access Denied");
include admintpl("header");
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td><?=$menu?></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr align="center">
    <th colspan=4>播放器管理</th>
  </tr>
  <tr align="center">
    <td class="tablerowhighlight">选中</td>
    <td class="tablerowhighlight">ID</td>
    <td class="tablerowhighlight">名称</td>
    <td class="tablerowhighlight">管理操作</td>
  </tr>
  <form name="myform" method="post" action="?">
<?php
if(is_array($movie)) {
	foreach($movie AS $k) {
?>
  <tr align='center' onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5'>
	<td class="tablerow"><input name='playerid[]' type='checkbox' id='playerid[]' value='<?=$k['playerid']?>' 
	<?php	if($k['iscore'])	echo 'disabled readonly=true';?> ></td>
    <td><?=$k['playerid']?></td>
    <td><?=$k['subject']?></td>
    <td><a href="?mod=movie&file=player&action=edit&playerid=<?=$k['playerid']?>">编辑</a> | 
	<?php if(!$k['disabled']) {?>
	<a href="?mod=movie&file=player&action=disabled&disabled=1&playerid=<?=$k['playerid']?>"><font color="#ff0000">启用</font></a>
	<?php
	}	else	{?>
	<a href="?mod=movie&file=player&action=disabled&disabled=0&playerid=<?=$k['playerid']?>">禁用</a>
	<?php }?>| <?php	if(!$k['iscore']) {?><a href="?mod=movie&file=player&action=delete&playerid=<?=$k['playerid']?>">删除</a><?php } else {?> <font color="#888888">删除</font><?php }?> </td>
  </tr>

<?php
	}}
?>
</table>
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
        <input name='submit2' type='submit' value='启用播放器' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=disabled&disabled=1'" >&nbsp;
        <input name='submit3' type='submit' value='禁用播放器' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=disabled&disabled=0'" >&nbsp;
		<input name='submit4' type='submit' value='删除播放器'		onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'"></td>
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
	1、系统自带播放器只可修改不能删除<br/>
	2、可以通过禁用播放器来取消默认播放器的使用<br/>
	3、用户自己添加的播放器只能通过手动选择播放器使用，不能使用自动选择播放器<br/>
	4、RealPlayer支持格式： wmv|avi|rmvb|rm|smi|mpg|ram<br/>
	5、mediaplayer支持格式：wmv|avi|mp4|mpeg|mpg|wma<br/>
	</td>
  </tr>
</table>
</body>
</html>