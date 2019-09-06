<?php include "./install/header.tpl.php";?>
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
        <td  colspan="2" style="background:url('install/images/install_banner.jpg') no-repeat right;"><font color="#383F69"><strong>完成安装</strong></font><br>
<font color="#383F69">程序安装完成</font></td>
      </tr>
	  <tr>
        <td height="2" colspan="2" class="tr-bottom-bg"></td>
        <td width="470" height="2" class="tr-bottom-bg"></td>
	  </tr>
      <tr  class="tr-bottom">
        <td height="230" colspan="3">         
          <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="12" rowspan="3">&nbsp;</td>
              <td height="28" colspan="3">&nbsp; </td>
              </tr>
            <tr>
              <td colspan="3" valign="top">恭喜，PHPCMS2007程序安装全部完成，<?php if($isupdate) echo "下一步继续进行PHPCMS3.0->2007的升级！"; else echo "单击完成进入网站后台。";?>                </td>
              </tr>
            <tr>
              <td colspan="3" align="center" valign="top"><img src="images/logo.jpg" align="middle" style="border:solid 1px #495860;cursor:pointer;" onClick="location.href='<?php if($isupdate) echo "phpcms_3_0_0_to_2007.php"; else echo "admin.php";?>'"></td>
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
              <input class="btn" onClick="location.href='javascript: history.go(-1);'" type=reset value="上一步(P)" name=reset disabled>
              <input class="btn" onClick="location.href='<?php if($isupdate) echo "phpcms_3_0_0_to_2007.php"; else echo "admin.php";?>'" type=reset value="<?php if($isupdate) echo "继续升级"; else echo "完成(F)";?>" name=reset2>
</div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table></td>
  </tr>
</table>
<?php include "./install/footer.tpl.php";?>