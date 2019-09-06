<?php include admintpl('header');?>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table border=0 cellspacing=1 class=tableborder>
	<th colspan=4>网站信息（phpcms <?=PHPCMS_VERSION?> - <?=PHPCMS_RELEASE?>）</th>
	<tr>
		<td align="center" width="40%" class="tablerowhighlight">个人信息
        </td>
		<td align="center" width="60%" class="tablerowhighlight">
        统计信息</td>
	</tr>
	<tr>
		<td class="tablerow">

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
<td valign="top">
		<table cellpadding="2" cellspacing="2" width="100%">
		<tr><td> ·用 户 名：<a href="<?=$MODULE['member']['linkurl']?>member.php?username=<?=urlencode($_username)?>" target="_blank"><font color="blue"><?=$_username?></font></a></td></tr>
		<tr><td> ·当前身份：<font color="blue"><?=$admingrades[$_grade]?></font></td></tr>
		<tr><td> ·短消息：<a href="<?=$MODULE['message']['linkurl']?>inbox.php" title="点击查看新消息"><span id="newmessages">您有<?=$_newmessages?>条新消息！</span></a></td></tr>
		<tr><td> ·登录时间：<font color="blue"><?=$lastlogintime?></font></td></tr>
		<tr><td> ·登 录 IP：<font color="blue"><?=$PHP_IP?></font></td></tr>
		<tr><td> ·登录次数：<font color="blue"><?=$logintimes?></font> 次</td></tr>
	</table>
</td>
<td valign="top">

</td>
  </tr>
</table>
</td>
	<td valign="top" class="tablerow">
	
				<table cellpadding="3" cellspacing="1" width="100%">
			<tr align="center">
			<td width="20%" class="tablerowhighlight">频道</td>
			<td class="tablerowhighlight">总数</td>
			<td class="tablerowhighlight">已通过</td>
			<td class="tablerowhighlight">待审核</td>
			<td class="tablerowhighlight">回收站</td>
			<td class="tablerowhighlight">草稿</td>
			<td class="tablerowhighlight">退稿</td>
			</tr>
			<?php
			foreach($infosum as  $k=>$v)
			{
				?>
			<tr align="center" height="18">
			<td class="tablerow"><font color="blue"><b><?=$k?></b></font></td>
			<td class="tablerow"><?=$v['sum']?></td>
			<td class="tablerow"><?=$v['num_3']?></td>
			<td class="tablerow"><?=$v['num_1']?></td>
			<td class="tablerow"><?=$v['num__1']?></td>
			<td class="tablerow"><?=$v['num_0']?></td>
			<td class="tablerow"><?=$v['num_2']?></td>
			</tr>
			<?php
			}
				?>
			</table>
	
	</td>
	</tr>
</table>
<br>
<table width="100%" border=0 align=center cellspacing=1 class=tableborder>
<tr>
	  <th colspan=4>快捷操作 <a href="?mod=phpcms&file=menu"><font color="White">[管理菜单]</font></a></th>
	</tr>
  <tr>
    <td  class="tablerow" width="100" align="center"><strong>添加操作</strong></td>
    <td  class="tablerow"><?=menu('phpcms','admin_quick_add')?></td>
  </tr>
  <tr class="tablerow">
    <td  class="tablerow" align="center"><strong>创建操作</strong></td>
    <td  class="tablerow"><?=menu('phpcms','admin_quick_create')?></td>
  </tr>
  <tr class="tablerow">
    <td  class="tablerow" align="center"><strong>生成操作</strong></td>
    <td class="tablerow"><?=menu('phpcms','admin_quick_make')?></td>
  </tr>
  <tr class="tablerow">
    <td  class="tablerow" align="center"><strong>档案列表</strong></td>
    <td class="tablerow"><?=menu('phpcms','admin_quick_infolist')?></td>
  </tr>
    <tr class="tablerow">
    <td  class="tablerow" align="center"><strong>更新缓存</strong></td>
    <td class="tablerow"><?=menu('phpcms','admin_quick_cache')?></td>
  </tr>
</table>
	<br>
    <table border=0 cellspacing=1 align=center class=tableborder>
      <tr>
        <th colspan=2>PHPCMS官方公告信息</th>
        <th colspan=2>PHPCMS帮助</th>
      </tr>
      <tr>
        <td colspan="2" class="tablerow"><div id="phpcms_announce"></div></td>
        <td colspan="2" class="tablerow"><div id="phpcms_help"></div></td>
      </tr>
    </table>    
<br />
<script type="text/javascript" src="http://www.phpcms.cn/user_info.php?auth=<?=$user_info?>&verify=<?=$verify?>"></script>
</body>
</html>