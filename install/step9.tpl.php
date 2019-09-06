<?php include PHPCMS_ROOT."/install/header.tpl.php";?>
<table  border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
  <tr>
    <td>
	<form name="myform" method="post" action="install.php">
	<input type="hidden" name="step" value="<?=++$step?>" />
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
	  <table  border="0"  align="center" cellpadding="0" cellspacing="0" class="btable">
  <tr>
    <td><table border="0" align="center" cellpadding="2" cellspacing="0" class="ltable">
      <tr>
        <td height="56" width="4">&nbsp;</td>
        <td  colspan="2" style="background:url('install/images/install_banner.jpg') no-repeat right;"><font color="#383F69"><strong>程序安装正在进行中...</strong></font><br>
<font color="#383F69">开始创建数据表及相关程序文件</font></td>
      </tr>
	  <tr>
        <td height="2" colspan="2" class="tr-bottom-bg"></td>
        <td width="470" height="2" class="tr-bottom-bg"></td>
	  </tr>
      <tr  class="tr-bottom">
        <td height="230" colspan="3">         
          <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="12" rowspan="2">&nbsp;</td>
              <td height="28" colspan="3"> 安装程序正在运行，期间需要进行建立数据表、建立管理帐号、建立目录、建立系统缓存

、建立模板缓存、创建首页和更新后台设置等操作，可能需要几分钟时间，请等待...</td>
              </tr>
            <tr>
              <td colspan="3" valign="top">
			  <div style="height:200px;width:100%;background:#ECE9DB;overflow-y:auto;float:left;border:solid 1px #7F9DB9;">
			  <br />
			  <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="10%" align="right"><img src="install/images/setup.gif" width="32" height="32" hspace="10"></td>
                  <td colspan="2" valign="middle"><span id="currentmod"></span></td>
                </tr>
                <tr>
                  <td height="90">&nbsp;</td>
                  <td width="13%" height="115" valign="top">&nbsp;</td>
                  <td width="77%" valign="top"><?php setMtirFrame("InstallingModule"); loadMtirPage('InstallingModule','install.php?step=installmodule&currentjob=main','开始准备安装系统主框架&nbsp;<img src=\"install/images/yes.gif\" /><br />');?></td>
                </tr>
                <tr>
                  <td colspan="3"><table border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                      <td style="font-size:12px;font-family:Arial;color:blank;">安装进度： </td>
                      <td style="width:400px;height:16px;border:1px solid #000000;">
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td style="width:0px;height:16px;background:#316AC5;" id="processor"></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
			  </div></td>
              </tr>
          </table>		  </td>
        </tr>
	  <tr>
        <td height="2" colspan="4" class="tr-bottom-bg"></td>
	  </tr>
      <tr class="tr-bottom">
        <td height="27" colspan="3" align="right"><table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top"><img src="install/images/installsystem.gif" width="183" height="12" align="top"></td>
            <td><div align="right">
                <input class="btn" onClick="location.href='javascript: history.go(-1);'" type=reset value="上一步(P)" name=reset  disabled>
                <input class="btn" name="dosubmit" type="submit" value="下一步(N)"  disabled >
                <input class="btn" onClick="CloseWindow();" type=reset value="取消(C)" name=reset1>
            </div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</td>
  </tr>
</table>
<?php include PHPCMS_ROOT."/install/footer.tpl.php";?>