<?php include PHPCMS_ROOT.'install/header.tpl.php';?>
<div class="content">
<?php if($no_writablefile !='') { ?>
<font color="#FF0000">
目录文件属性检测结果：<br></font>
<font color="#FFFF00">
<?php echo $no_writablefile;?>
</font>
<?php
	if(extension_loaded('ftp'))
	{
?>
	<input type="button" onclick="window.location.reload()" value="重新检测" class="btn">
	<input type="button" onclick="showftpset()" value="通过FTP设置目录文件属性" class="btn">
	<div class="c" id="ftpset" style="display:none">
	<form name="myform" action="install.php?" method="post">
	<table width="100%" cellspacing="1" cellpadding="1" >
	<caption>
	目录文件属性设置：
	</caption>
	<tr>
	<th width="30%" align="right">ftp主机：</th>
	<td><input name="ftphost" type="text" id="ftphost" value="<?=FTP_HOST?>" size="20" class="txt_box" title="一般情况默认即可，设置不成功时请重新填写主机地址"/> 当前服务器IP地址：<?php echo gethostbyname($SCRIPT_NAME);?> <font color="#0000FF"></font></td>
	</tr>
	<tr>
	<th align="right">主机端口：</th>
	<td><input name="ftpport" type="text" id="ftpport" size="10"  value="<?=FTP_PORT?>" class="txt_box" /></td>
	</tr>
	<tr>
	<th align="right">ftp帐号：</th>
	<td><input name="ftpuser" type="text" id="ftpuser" size="20" class="txt_box" value="<?=FTP_USER?>"/></td>
	</tr>
	<tr>
	<th align="right">ftp密码：</th>
	<td><input name="ftppass" type="password" id="ftppass" size="20" class="txt_box" value="<?=FTP_PW?>" onblur="ftpdir_list('/')"/></td>
	</tr>
	<tr>
	<th align="right">网站相对ftp根目录的路径：<br /></th>
	<td><input name="ftpwebpath" type="text" id="ftpwebpath" size="20" class="txt_box" value="<?=FTP_PATH?>"/>
	 <span id="ftpdir_list"></span><BR>例如 /wwwroot/ 或者 /www/，与ftp根目录相同则留空 
	  <input type="hidden" id="ftpselectmod" name="ftpselectmod" value="<?=$selectmod?>" />
	<iframe id="ftpiframe" name="ftpiframe" src="install/blank.html" width="0" height="0"></iframe>
	</td>
	</tr>
	<tr>
	<td></td>
	<td style="height:30px; line-height:30px;">
	  <input type="button" name="useftp"  id="useftp" class="btn" value="立刻设置" onclick="ftpiframe.location='?step=ftpset&ftphost='+myform.ftphost.value+'&ftpport='+myform.ftpport.value+'&ftpuser='+myform.ftpuser.value+'&ftppass='+myform.ftppass.value+'&ftpwebpath='+myform.ftpwebpath.value+'&selectmod='+myform.ftpselectmod.value"  />
	</td>
	</tr>
	</table>
	</form>
	</div>
	<?php
	}
	else
	{
	?><BR>
	<input type="button" onclick="window.location.reload()" value="非常抱歉，您的服务器不支持FTP扩展功能，请手动设置以上目录和文件，然后点击这里重新检测" class="btn2">
<?php
	}
}
else
{
?>
<a href="javascript:history.go(-1);" class="btn">返回上一步：<?php echo $steps[--$step];?></a> 
<a onClick="$('#install').submit();" class="btn">检测通过，下一步</a>
<form id="install" action="install.php?" method="post">
<input type="hidden" name="testdata" value="<?=$testdata?>" />
<input type="hidden" name="module" id="module" value="<?=$module?>" />
<input type="hidden" id="selectmod" name="selectmod" value="<?=$selectmod?>" />
<input type="hidden" name="step" value="6">
 </form>
<?php
}
?>
</div>
</div>
</div>
<script language="JavaScript">
<!--
	function showftpset() {
		$("#ftpset").toggle();
	}
	function ftpdir_list(path)
	{
		$.get('install.php?step=ftpdir_list&path='+path+'&ftphost='+$('#ftphost').val()+'&ftpport='+$('#ftpport').val()+'&ftpuser='+$('#ftpuser').val()+'&ftppw='+$('#ftppass').val(), function(data){
			if(data != 0) $('#ftpdir_list').append(data);
		});
	}
//-->
</script>
</body>
</html>