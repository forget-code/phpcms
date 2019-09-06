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
		<td class="tablerow" width="20%"></td>
		<td class="tablerow" width="20%"></td>
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
		<td class="tablerow" width="20%">Sendmail</td>
		<td class="tablerow" width="20%"></td>
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
	<br />
	<?=$phpinfo?>
</body>
</html>