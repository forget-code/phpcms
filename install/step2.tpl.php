<?php include PHPCMS_ROOT."/install/header.tpl.php";?>
<body class="body">
<table  border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
  <tr>
    <td>
	
	  <table  border="0" cellpadding="0" cellspacing="0" class="ttable" align="center">
        <tr>
          <td><table  border="0" align="center" cellpadding="2" cellspacing="0"  class="ttable">
              <tr>
                <td width="5" height="5" class="td-left-top"></td>
                <td class="td-l-top"></td>
                <td class="td-l-top"></td>
                <td width="5" height="5" class="td-right-top"></td>
              </tr>
              <tr class="tr-l-bottom">
			   <td></td>
                <td class="txttitle"><img src="install/images/ico.jpg" width="14" height="14" align="absmiddle"/>&nbsp;PHPCMS 程序安装向导</td>
			    <td align="right" valign="top">
				<img src="install/images/minimum.gif"  style="cursor:pointer;" onClick="MiniWindow();" title="最小化到状态栏"><img src="install/images/maxmum.gif"><img src="install/images/close.gif" style="cursor:pointer;" onClick="CloseWindow();" title="退出安装程序"></td>
			    <td></td>
              </tr>
          </table></td>
        </tr>
      </table>
	  <table  border="0" cellpadding="0" cellspacing="0" class="btable"  align="center">
  <tr>
    <td><table  border="0" align="center" cellpadding="1" cellspacing="0" class="ltable">
      <tr>
        <td width="163" height="284" rowspan="2"><img src="install/images/install_logo.gif" width="163" height="283"></td>
        <td width="26" rowspan="2">&nbsp;</td>
        <td width="301"><h3>欢迎使用<?php echo $PHPCMS_VERSION_NAME; if($PHPCMS_VERSION_BUILD_TIME) echo '(build '.$PHPCMS_VERSION_BUILD_TIME.')';?>安装向导</h3></td>
      </tr>
      <form name="newupdate" action="install.php?step=<?php echo ++$step;?>" method="POST">
      <tr>
        <td valign="top" class="tdtxt">请选择安装方式<br>
<input name="radiobutton"  id="radiobutton1" type="radio" value="1" checked>
全新安装<br>
<input type="radio" name="radiobutton" id="radiobutton2" value="2">
从3.0版本升级 
<img src="images/help.gif" style="cursor:pointer;" alt="查看升级说明" align="absmiddle" onclick="confirm('&nbsp;此升级程序适用于 phpcms 3.0.0 到 phpcms 2007 的数据库升级，升级后原来的模板将不可用。\n请确认升级前已经将phpcms_3_0_0_to_2007.php文件上传至phpcms根目录\n1、通过phpcms后台的数据库管理功能或者其他工具备份数据库，通过ftp备份好附件、模板风格和config.php文件。\n2、删除空间上除了各个频道目录、uploadfile、thumb和config.php之外的phpcms文件和目录。注意：请不要误删除phpcms之外的其他程序文件和目录。\n3、上传 phpcms 2007 的程序到服务器覆盖原来的。\n4、通过浏览器访问install.php文件，安装 phpcms 2007。注意：安装的时候把表前缀修改为 phpcms7_，不能与原来的 3.0.0 表前缀相同\n5、通过浏览器访问phpcms_3_0_0_to_2007.php文件，根据升级向导提示进行升级。\n6、登陆后台 => 进入各频道 => 发布网页(html) => 更新频道 => 批量生成文章。\n7、确认数据库升级成功后，可以通过 phpmyadmin 等数据库管理工具删除原来 phpcms 3.0.0 的数据表。如果您不会操作，也可以不删除。');" /><span id='updateinfo'></span><br>(选择直接升级安装强烈要求您先备份数据)<br><br>
单击&nbsp;[下一步(N)]&nbsp;继续,取消退出安装程序. <br></td>
      </tr>
	  <tr>
        <td height="2" colspan="3" class="tr-bottom-bg"></td>
      </tr>
      <tr class="tr-bottom">
        <td colspan="2" align="right" valign="top"><img src="install/images/installsystem.gif" width="183" height="12" align="top">&nbsp;&nbsp;</td>
        <td align="right"><input class="btn" onClick="location.href='javascript: history.go(-1);'" type=reset value="上一步(P)" name=reset2>
          &nbsp;<input type="reset" onClick="if(document.getElementById('radiobutton2').checked==true){if(confirm('&nbsp;此升级程序适用于 phpcms 3.0.0 到 phpcms 2007 的数据库升级，升级后原来的模板将不可用。\n请确认升级前已经将phpcms_3_0_0_to_2007.php文件上传至phpcms根目录\n1、通过phpcms后台的数据库管理功能或者其他工具备份数据库，通过ftp备份好附件、模板风格和config.php文件。\n2、删除空间上除了各个频道目录、uploadfile、thumb和config.php之外的phpcms文件和目录。注意：请不要误删除phpcms之外的其他程序文件和目录。\n3、上传 phpcms 2007 的程序到服务器覆盖原来的。\n4、通过浏览器访问install.php文件，安装 phpcms 2007。注意：安装的时候把表前缀修改为 phpcms7_，不能与原来的 3.0.0 表前缀相同\n5、通过浏览器访问phpcms_3_0_0_to_2007.php文件，根据升级向导提示进行升级。\n6、登陆后台 => 进入各频道 => 发布网页(html) => 更新频道 => 批量生成文章。\n7、确认数据库升级成功后，可以通过 phpmyadmin 等数据库管理工具删除原来 phpcms 3.0.0 的数据表。如果您不会操作，也可以不删除。')) document.getElementById('newupdate').submit();} else document.getElementById('newupdate').submit(); "  value="下一步(N)" name="reset" class="btn">
&nbsp;<input  type="reset" onClick="CloseWindow();"  value="取消(C)" name="res"  class="btn"></td>
      </tr>
      </form>
    </table></td>
  </tr>
</table></td>
  </tr>
</table>
<?php include PHPCMS_ROOT."/install/footer.tpl.php";?>