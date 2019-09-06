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
    <th colspan=7>影片服务器列表</th>
  </tr>
  <tr align="center">
    <td class="tablerowhighlight">ID</td>
    <td class="tablerowhighlight">服务器描述</td>
    <td class="tablerowhighlight">在线服务器地址</td>
    <td class="tablerowhighlight">下载服务器地址</td>
    <td class="tablerowhighlight">最大上线人数</td>
    <td class="tablerowhighlight">当前播放人数</td>
    <td class="tablerowhighlight">管理操作</td>
  </tr>
  <form name="myform" method="post" action="?">
<?php
if(is_array($server)) {
	foreach($server AS $k) {
?>
  <tr align='center' onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5'>
    <td><?=$k['serverid']?></td>
    <td><?=$k['servername']?></td>
    <td><?=$k['onlineurl']?></td>
    <td><?=$k['downurl']?></td>
    <td><?=$k['maxnum']?></td>
    <td><a href="?mod=movie&file=server&action=destroy&serverid=<?=$k['serverid']?>" title="归零"><?=$k['num']?></a></td>
    <td><a href="?mod=movie&file=server&action=edit&serverid=<?=$k['serverid']?>">编辑</a> |
	<a href=javascript:confirmurl('?mod=movie&file=server&action=delete&serverid=<?=$k['serverid']?>','删除服务器地址后，之前应用此服务器的的影片将不能播放，确认删除吗？')>删除</a></td>
  </tr>

<?php
	}}
?>
</table>

</form>
<br/>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	1、删除服务器地址后，之前应用此服务器的的影片将不能播放<br/>
	2、通过修改服务器播放地址或者下载地址可以一定程度防止盗链<br/>
	3、推荐使用 VirtualWall 防盗链软件  <a href="http://www.fangdaolian.com" target="_blank">http://www.fangdaolian.com</a>	</td>
  </tr>
</table>

</body>
</html>