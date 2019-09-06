<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table border=0 cellspacing=1 class=tableborder>
	<th colspan=4>网站信息 </th>
	<tr>
		<td align="center" width="50%" class="tablerowhighlight">个人信息</td>
		<td align="center" width="50%" class="tablerowhighlight">使用向导</td>
	</tr>
	<tr>
        <td class="tablerow">
		<table cellpadding="2" cellspacing="2" width="100%">
		<tr><td> ·用 户 名：<a href="<?=$MODULE['member']['linkurl']?>member.php?username=<?=urlencode($_username)?>" target="_blank"><font color="blue"><?=$_username?></font></a></td></tr>
		<tr><td> ·当前身份：<font color="blue"><?=$GROUP['groupname']?></font></td></tr>
		<tr><td> ·短消息：<a href="<?=$MODULE['message']['linkurl']?>inbox.php" title="点击查看新消息"><span id="newmessages">您有<?=$_newmessages?>条新消息！</span></a></td></tr>
		<tr><td> ·登录时间：<font color="blue"><?=$lastlogintime?></font></td></tr>
		<tr><td> ·登 录 IP：<font color="blue"><?=$PHP_IP?></font></td></tr>
		<tr><td> ·登录次数：<font color="blue"><?=$logintimes?></font> 次</td></tr>
		<tr><td> ·企业主页访问地址：<a href="<?=$INDEX?>" target="_blank"><font color="blue"><?=$INDEX?></font></a></td></tr>
		<tr><td> ·企业后台管理地址：<a href="<?=$SITEURL?>/yp/admin.php" target="_blank"><font color="blue"><?=$SITEURL?>/yp/admin.php</font></a></td></tr>
		<tr><td> ·最新订单数：<font color="red"><?=$new_order_num?></font> 条 <?php if($new_order_num) echo '<a href="?file=order&action=manage"><font color="#ff0000">立即查看</font></a>';?></td></tr>
		<tr><td> ·最新留言数：<font color="red"><?=$new_message_num?></font> 条 <?php if($new_message_num) echo '<a href="?file=guestbook&action=manage"><font color="#ff0000">立即查看</font></a>';?></td></tr>
		</table>
		<td class="tablerow" valign="top">
		1、基本设置--公司信息修改和确认<BR>
	2、模板管理--设置企业自己的导航<BR>
	3、Banner管理--上传和修改企业自己的logo 和整体背景<BR>
	4、修改公司简介<BR>
	5、添加信息</td>
	</tr>
      </tr>
    </table><BR>
	<table cellpadding="2" cellspacing="1" border="0" width="100%" height="10" class=tableborder>
	<th colspan=4>官方最新消息</th>
  <tr>
    <td>
	<?=$MOD['notice']?>
	</td>
  </tr>
</table>
</body>
</html>