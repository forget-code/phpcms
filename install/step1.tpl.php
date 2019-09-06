<?php include PHPCMS_ROOT."/install/header.tpl.php";?>
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
        <td width="163" height="283" rowspan="2" valign="top"><img src="install/images/install_logo.gif" width="163" height="283"></td>
        <td width="32" rowspan="2">&nbsp;</td>
        <td width="573"><h3>欢迎使用<?php echo $PHPCMS_VERSION_NAME; if($PHPCMS_VERSION_BUILD_TIME) echo '(build '.$PHPCMS_VERSION_BUILD_TIME.')';?>安装向导</h3></td>
      </tr>
      <tr>
        <td valign="top" class="tdtxt">该向导将帮助您完成PHPCMS的安装，
          <br>
          强烈建议您在继续安装之前关闭其他所有正在运行的程序,以避免安装
过程中可能产生的相互冲突。<br>
<br>
<br>
单击&nbsp;[下一步(N)]&nbsp;继续,取消退出安装程序. <br></td>
      </tr>
	  <tr>
        <td height="2" colspan="3" class="tr-bottom-bg"></td>
      </tr>
      <tr class="tr-bottom">
        <td colspan="2" valign="top"><img src="install/images/installsystem.gif" width="183" height="12" align="top">&nbsp;&nbsp;</td>
        <td align="right">
        <input type="reset" onClick="location='install.php?step=<?=++$step?>'"  value="下一步(N)" name="reset" class="btn">

        <input  type="reset" onClick="CloseWindow();"  value="取消(C)" name="res"  class="btn"></td>
      </tr>
    </table></td>
  </tr>
</table></td>
  </tr>
</table>
<script type="text/javascript" src="http://www.phpcms.cn/update/check_version.php?version=<?=PHPCMS_VERSION?>&release=<?=PHPCMS_RELEASE?>"></script>
<?php include PHPCMS_ROOT."/install/footer.tpl.php";?>