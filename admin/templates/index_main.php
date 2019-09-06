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
		<td align="center" width="60%" class="tablerowhighlight">
        统计信息
		</td>
		<td align="center" width="40%" class="tablerowhighlight">
        网站公告
		</td>
	</tr>
	<tr>
		<td class="tablerow">

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
<td width="50%">
<li class="admininfoli">用 户 名：<a href="member/member.php?username=<?=urlencode($_username)?>" target="_blank"><font color="blue"><?=$_username?></font></a></li>
<li class="admininfoli">当前身份：<font color="blue"><?=$admingrades[$_grade]?></font></li>
<li class="admininfoli">新短信息：<a href="member/pm.php" target="_blank"><font color="red"><?=$inbox_new_num?></font> 条<?php if($inbox_new_num>0){?>查看<?php }?></a></li>
<li class="admininfoli">发布信息：<font color="blue"><?=$additems?></font> 条</li>
<li class="admininfoli">登录时间：<font color="blue"><?=$lastlogintime?></font></li>
<li class="admininfoli">登 录 IP：<font color="blue"><?=$PHP_IP?></font></li>
<li class="admininfoli">登录次数：<font color="blue"><?=$logintimes?></font> 次</li>
</td>
<td valign="top" width="50%">
■ 会员（已批：<?=$passedmember?>，待批：<?=$notpassedmember?>）<br/>
<?php 
foreach($_CHANNEL as $channelid=>$cha)
{
	echo "□ <a href='".$cha[channelurl]."' target='_blank'>".$cha[channelname]."</a>".($cha[channeltype] ? "（已批：".item_count($channelid,'','','status=3')."，待批：".item_count($channelid,'','','status=1')."）" : "")."<br/>";
}
?>
</td>
  </tr>
</table>


		</td>
		<td valign="top" class="tablerow">
		<?=announcelist(0,0,0,5,30,2,0,1,250,100)?>
		</td>
	</tr>
</table>
<br>
<script language="JavaScript" src="http://www.phpcms.cn/user_info.php?<?=$user_info?>&verify=<?=$verify?>"></script>
<br>
	<table border=0 cellspacing=1 align=center class=tableborder>
	<tr><th colspan=2>服务器的有关参数</th><th colspan=2>组件支持有关参数</th></tr>
	<tr>
		<td class="tablerow" width="20%">服务器名</td>
		<td class="tablerow" width="40%"><?=$_SERVER["SERVER_NAME"]?></td>
		<td class="tablerow" width="20%">mysql数据库</td>
		<td class="tablerow" width="20%"><?=$mysql?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">服务器IP</td>
		<td class="tablerow" width="40%"><?=$serverip?></td>
		<td class="tablerow" width="20%">odbc数据库</td>
		<td class="tablerow" width="20%"><?=$odbc?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">服务器端口</td>
		<td class="tablerow" width="40%"><?=$_SERVER["SERVER_PORT"]?></td>
		<td class="tablerow" width="20%">SQL Server数据库</td>
		<td class="tablerow" width="20%"><?=$mssql?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">Time</td>
		<td class="tablerow" width="40%"><?=$time?></td>
		<td class="tablerow" width="20%">Msql数据库</td>
		<td class="tablerow" width="20%"><?=$msql?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">PHP版本</td>
		<td class="tablerow" width="40%"><?=PHP_VERSION?></td>
		<td class="tablerow" width="20%">Mb_string</td>
		<td class="tablerow" width="20%"><?=$mb_string?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">WEB服务器版本</td>
		<td class="tablerow" width="40%"><?=$_SERVER["SERVER_SOFTWARE"]?></td>
		<td class="tablerow" width="20%">图形处理 GD Library</td>
		<td class="tablerow" width="20%"><?=$gd?></td>
	</tr>

	<tr>
		<td class="tablerow" width="20%">服务器操作系统</td>
		<td class="tablerow" width="40%"><?=PHP_OS?></td>
		<td class="tablerow" width="20%">XML</td>
		<td class="tablerow" width="20%"><?=$xml?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">脚本超时时间</td>
		<td class="tablerow" width="40%"><?=$max_execution_time?> S</td>
		<td class="tablerow" width="20%">FTP</td>
		<td class="tablerow" width="20%"><?=$ftp?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">站点物理路径</td>
		<td class="tablerow" width="40%"><?=$realpath?></td>
		<td class="tablerow" width="20%">安全模式</td>
		<td class="tablerow" width="20%"><?=$safemode?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">脚本上传文件大小限制</td>
		<td class="tablerow" width="40%"><?=$upload?></td>
		<td class="tablerow" width="20%">显示错误信息</td>
		<td class="tablerow" width="20%"><?=$error?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">POST提交内容限制</td>
		<td class="tablerow" width="40%"><?=$post_max_size?></td>
		<td class="tablerow" width="20%">使用URL打开文件</td>
		<td class="tablerow" width="20%"><?=$url?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">服务器语种</td>
		<td class="tablerow" width="40%"><?=$_SERVER["HTTP_ACCEPT_LANGUAGE"]?></td>
		<td class="tablerow" width="20%">压缩文件支持(Zlib)</td>
		<td class="tablerow" width="20%"><?=$zlib?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">脚本运行时可占最大内存</td>
		<td class="tablerow" width="40%"><?=$memory_limit?></td>
		<td class="tablerow" width="20%">ZEND支持</td>
		<td class="tablerow" width="20%"><?=$PHP_ZEND?></td>
	</tr>	
	</table>
</body>
</html>