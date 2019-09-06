<?php include PHPCMS_ROOT."/install/header.tpl.php";?>
<script type="text/javascript">
function checkform()
{
	if($F('username')=='' || $F('password')=='' || $F('pwdconfirm')=='' || $F('email')=='')
	{
		alert('请将内容填写完整');
		return false;
	}
	if($F('password')!=$F('pwdconfirm'))
	{
		alert('两次填写的密码不一致');
		return false;
	}
}
</script>

<table  border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
  <tr>
    <td>
     <form name="myformuser" method="post" action="install.php" onsubmit="return checkform();">
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
        <td  colspan="2" style="background:url('install/images/install_banner.jpg') no-repeat right;"><font color="#383F69"><strong>超级管理员设置</strong></font><br>
<font color="#383F69">该用户拥有该网站的全部管理权限</font></td>
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
              <td height="28" colspan="3"> 请设置超级管理员用户名及密码，完成后单击 [下一步(N)] 继续。                </td>
              </tr>
            <tr>
              <td colspan="3" valign="top">
			  <div style="height:200px;width:100%;background:#ECE9DB;overflow-y:auto;float:left;border:solid 1px #7F9DB9;">
			    <table width="100%" border="0" cellspacing="1" cellpadding="0"  bgcolor="#FFFFFF">
                  <tr bgcolor="#ECE9DB">
                    <td width="27%"  align="right"><strong>帐号：</strong></td>
                    <td width="73%" align="left"><input name="username" type="text" id="username" value="phpcms" size="20" style="width:150px"/>
      3到20个字符，不含非法字符！</td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="right"><strong>密码：</strong></td>
                    <td align="left"><input name="password" type="password" id="password" size="20" value="phpcms" style="width:150px"/>
      4到20个字符<font color="red">(默认为phpcms)</font></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="right"><strong>确认密码：</strong></td>
                    <td align="left"><input name="pwdconfirm" type="password" id="pwdconfirm" size="20"  value="phpcms"  style="width:150px"/></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="right"><strong>E-mail：</strong></td>
                    <td align="left"><input name="email" type="text" id="email" size="20" style="width:150px" value="name@domain.com"/></td>
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
                <input class="btn" name="dosubmit" type="button" onclick="<?php  if($installed) echo "if(confirm('您已经安装过phpcms，前缀相同系统会自动删除原来的数据！是否继续？')){ document.getElementById('myformuser').submit();}"; else echo "document.getElementById('myformuser').submit();"; ?>" value="下一步(N)">
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