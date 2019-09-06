<?php include admintpl('header');?>
<body>
	<table border=0 cellspacing=1 align=center class=tableborder>
	<tr><th colspan=4>统计信息</th></tr>
	<tr>
		<td colspan=4 class="tablerowhighlight"><?=$phpcms_user?>(<?=$_groupname?>)，您好！ 您本次登录时间为 <?=$lastlogintime?> ,IP是 <?=$ip?> ,总共登录 <?=$logintimes?> 次。</td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">待批会员数</td>
		<td class="tablerow" width="30%"><?=$passmember?></td>
		<td class="tablerow" width="20%">已批会员数</td>
		<td class="tablerow" width="30%"><?=$totalmember?></td>
	</tr>
	<tr>
		<td class="tablerow" width="25%">待批文章数</td>
		<td class="tablerow" width="25%"><?=$passarticle?></td>
		<td class="tablerow" width="25%">已批文章数</td>
		<td class="tablerow" width="25%"><?=$totalarticle?></td>
	</tr>
	<tr>
		<td class="tablerow" width="25%">待批评论数</td>
		<td class="tablerow" width="25%"><?=$passcomment?></td>
		<td class="tablerow" width="25%">已批评论数</td>
		<td class="tablerow" width="25%"><?=$totalcomment?></td>
	</tr>
	<tr>
		<td class="tablerow" width="25%">待批留言数</td>
		<td class="tablerow" width="25%"><?=$passreply?></td>
		<td class="tablerow" width="25%">已批留言数</td>
		<td class="tablerow" width="25%"><?=$totalreply?></td>
	</tr>
	</table>

	<br>
	<table border=0 cellspacing=1 align=center class=tableborder>
	<tr><th colspan=2>phpcms <?=$version?> 版权、常用联系方法、技术支持</th></tr>
	<tr>
		<td class="tablerow" width="20%">软件版本</td>
		<td class="tablerow" width="80%">phpcms Version <?=$version?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">版权所有</td>
		<td class="tablerow" width="80%"><a href="http://www.phpcms.cn" target="_blank">phpcms.cn</a></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">程序制作</td>
		<td class="tablerow" width="80%">phpcms开发团队</td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">官方网站</td>
		<td class="tablerow" width="80%"><a href="http://www.phpcms.cn" target=_blank>http://www.phpcms.cn</a></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">技术支持论坛</td>
		<td class="tablerow" width="80%"><a href="http://bbs.phpcms.cn" target=_blank>http://bbs.phpcms.cn</a></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">联系方式</td>
		<td class="tablerow" width="80%">OICQ:411109466&nbsp;&nbsp;&nbsp;&nbsp;Email:<a href="mailto:9466@9466.net">9466@9466.net</a></td>
	</tr>
	</table>

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
		<td class="tablerow" width="40%">{PHP_VERSION?></td>
		<td class="tablerow" width="20%">SMTP</td>
		<td class="tablerow" width="20%"><?=$smtp?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">WEB服务器版本</td>
		<td class="tablerow" width="40%"><?=$_SERVER["SERVER_SOFTWARE"]?></td>
		<td class="tablerow" width="20%">图形处理 GD Library</td>
		<td class="tablerow" width="20%"><?=$imageline?></td>
	</tr>

	<tr>
		<td class="tablerow" width="20%">服务器操作系统</td>
		<td class="tablerow" width="40%">{PHP_OS?></td>
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
		<td class="tablerow" width="20%">Sendmail</td>
		<td class="tablerow" width="20%"><?=$mail?></td>
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
		<td class="tablerow" width="20%"><?=$gzclose?></td>
	</tr>
	<tr>
		<td class="tablerow" width="20%">脚本运行时可占最大内存</td>
		<td class="tablerow" width="40%"><?=$memory_limit?></td>
		<td class="tablerow" width="20%">ZEND支持(1.3.0)</td>
		<td class="tablerow" width="20%"><?=$zend?></td>
	</tr>	
	</table>
</body>
</html>