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
	  <table  border="0"  align="center" cellpadding="0" cellspacing="0" class="btable">
  <tr>
    <td><table border="0" align="center" cellpadding="2" cellspacing="0" class="ltable">
      <tr>
        <td height="56" width="4">&nbsp;</td>
        <td  colspan="2" style="background:url('install/images/install_banner.jpg') no-repeat right;"><font color="#383F69"><strong>目录或文件可写检查</strong></font><br>
<font color="#383F69">linux服务器必须通过此步检测，<br>windows服务器可直接跳过</font></td>
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
              <td height="28" colspan="3"> 目录或文件不可写请通过FTP设置相应目录文件权限，如通过请单击 [下一步(N)] 继续。                </td>
              </tr>
              <tr>
              <td colspan="3" valign="top">
			  <div style="height:200px;width:100%;background:#ECE9DB;overflow-y:auto;float:left;border:solid 1px #7F9DB9;">
			  <?php
			  if(!ISUNIX)
              {
              	echo "<br /><br /><h4>经检测该服务器为windows服务器，请直接进入下一步</h4>";
              }
              else 
              {
		      ?>
			    <table cellpadding="2" width="100%" cellspacing="1" class="tableborder" align="center"  bgcolor="#FFFFFF">
					<form name="chmodform" method="post" action="install.php?step=showchmodlist" target="_blank"><input type="hidden" name="selectchannel" value="<?=htmlspecialchars($selectchannel)?>"><input type="hidden" name="selectmod" value="<?=htmlspecialchars($selectmod)?>">
                    <tr bgcolor="#ECE9DB">
                      <td align="center"><h4><font color=red>你的服务器为非windows类服务器</font></h4>必须设置部分目录和文件属性为：777<br />
					  <font color=red>如果您没有FTP帐号，请自行设置文件、目录权限：</font><input type="submit" value="查看列表" name="dosubmit">
					  </td>
                    </tr></form>
                    <tr bgcolor="#ECE9DB">
                      <td align="center" valign="top">
                        <table width="100%" border="0" cellspacing="1" cellpadding="1" border="1" >
                          <tr align="center">
                            <td colspan="4"><font color=red>如果您有FTP帐号：</font>请配置相关参数，程序将自动为您设置相关目录文件属性)</td>
                          </tr>
                          <tr>
                            <td align="right" width="40%"><strong>ftp主机：</strong></td>
                            <td align="left"><input name="ftphost" type="text" id="ftphost" value="<?=gethostbyname($PHP_DOMAIN)?>" size="20" style="width:150px"/></td>
                          </tr>
                          <tr>
                            <td align="right"><strong>主机端口：</strong></td>
                            <td align="left"><input name="ftpport" type="text" id="ftpport" size="10"  value="21" style="width:150px"/></td>
                          </tr>
                          <tr>
                            <td align="right"><strong>ftp帐号：</strong></td>
                            <td align="left"><input name="ftpuser" type="text" id="ftpuser" size="20" style="width:150px"/></td>
                          </tr>
                          <tr>
                            <td align="right"><strong>ftp密码：</strong></td>
                            <td align="left"><input name="ftppass" type="password" id="ftppass" size="20" style="width:150px"/></td>
                          </tr>
                          <tr>
                            <td align="right"><strong>网站相对ftp根目录的路径：</strong><br /></td>
                            <td align="left"><input name="ftpwebpath" type="text" id="ftpwebpath" size="20" style="width:150px"/>
                              <br>
                              例如/wwwroot/，与ftp根目录相同则留空
                <iframe id="ftpiframe" name="ftpiframe" src="install/blank.html" width="0" height="0"></iframe>
                            </td>
                          </tr>
                          <tr>
                            <td align="right"></td>
                            <td align="left">
                              <input type="button" name="useftp"  class="btn" value="测试并保存设置" onclick="ftpiframe.location='?step=ftpset&ftphost='+$('ftphost').value+'&ftpport='+$('ftpport').value+'&ftpuser='+$('ftpuser').value+'&ftppass='+$('ftppass').value+'&ftpwebpath='+$('ftpwebpath').value" style="width:150px;height:25px" />
                            </td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr bgcolor="#ECE9DB">
                      <td height="24" align="center"> <font color="red">请先通过ftp把以上目录都设置为 777 ，然后再继续安装</font></td>
                    </tr>                   
			      </table>
 					<?php
                    }
                    ?>
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
				<form name="myform" method="post" action="install.php" >
				<input type="hidden" name="step" value="<?=++$step?>" />
				<input type="hidden" name="selectchannel" value="<?=htmlspecialchars($selectchannel)?>" />
				<input type="hidden" name="selectmod" value="<?=htmlspecialchars($selectmod)?>" />
				<input type="hidden" name="selectcount" value="<?=$selectcount?>" />

				<input type="hidden" name="ftphost" id="ftphostinfo" value="" />
				<input type="hidden" name="ftpport" id="ftpportinfo" value="" />
				<input type="hidden" name="ftpuser" id="ftpuserinfo" value="" />
				<input type="hidden" name="ftppass" id="ftppassinfo" value="" />
				<input type="hidden" name="ftpwebpath" id="ftpwebpathinfo" value="" />
				<script type="text/javascript">
				function getftpinfo()
				{
					$('ftphostinfo').value=$('ftphost').value;
					$('ftpportinfo').value=$('ftpport').value;
					$('ftpuserinfo').value=$('ftpuser').value;
					$('ftppassinfo').value=$('ftppass').value;
					$('ftpwebpathinfo').value=$('ftpwebpath').value;
				}
				</script>

                <input class="btn" onClick="location.href='javascript: history.go(-1);'" type=reset value="上一步(P)" name=reset disabled>
               <input class="btn" name="dosubmit" id="dosubmit" type="submit" value="下一步(N)" onsubmit="return getftpinfo();">
                <input class="btn" onClick="CloseWindow();" type=reset value="取消(C)" name=reset1>

				</form>
            </div>
			
			</td>
          </tr>
        </table></td>
      </tr>
	 
    </table></td>
  </tr>
</table>
</td>
  </tr>
</table>
<?php include PHPCMS_ROOT."/install/footer.tpl.php";?>