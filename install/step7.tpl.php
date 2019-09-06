<?php include "./install/header.tpl.php";?>
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
        <td  colspan="2" style="background:url('install/images/install_banner.jpg') no-repeat right;"><font color="#383F69"><strong>程序初始化设置</strong></font><br>
<font color="#383F69">配置数据库配置连接及安装路径</font></td>
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
              <td height="28" colspan="3"> 请检查数据库连接配置并选择CMS安装路径，如通过请单击 [下一步(N)] 继续。                </td>
              </tr>
            <tr>
              <td colspan="3" valign="top">
			  <div style="height:200px;width:100%;background:#ECE9DB;overflow-y:auto;float:left;border:solid 1px #7F9DB9;">
			    <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#FFFFFF" >
                  <tr bgcolor="#ECE9DB">
                    <td width="30%" align="right" class="tablerow"><strong>数据库服务器：</strong></td>
                    <td width="70%" align="left" class="tablerow"><label>
                      <input name="dbhost" type="text" id="dbhost" value="localhost" size="20" style="width:150px"/>
                    </label></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="right" class="tablerow"><strong>数据库帐号：</strong></td>
                    <td align="left" class="tablerow"><input name="dbuser" type="text" id="dbuser" value="<?=$CONFIG['dbuser']?>" size="20" style="width:150px"/></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="right" class="tablerow"><strong>数据库密码：</strong></td>
                    <td align="left" class="tablerow"><input name="dbpw" type="password" id="dbpw" value="<?=$CONFIG['dbpw']?>" size="20" style="width:150px"/></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="right" class="tablerow"><strong>数据库名称：</strong></td>
                    <td align="left" class="tablerow"><input name="dbname" type="text" id="dbname" value="<?=$CONFIG['dbname']?>" size="20" style="width:150px"/></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="right" class="tablerow"><strong>数据表前缀：</strong></td>
                    <td align="left" class="tablerow"><input name="tablepre" type="text" id="tablepre" value="<?=$CONFIG['tablepre']?>" size="20" style="width:150px"/>  <img src="images/help.gif" style="cursor:pointer;" alt="查看帮助" align="absmiddle" onclick="help('helptablepre','<br />如果一个数据库安装多个phpcms，请修改表前缀');" />
      <span id='helptablepre'></span></td>
                  </tr>
                   <tr bgcolor="#ECE9DB">
                    <td align="right" class="tablerow"><strong>数据库字符集：</strong></td>
                    <td align="left" class="tablerow">
                    <input name="dbcharset" type="radio" id="dbcharset" value="" <?php if(strtolower($CONFIG['dbcharset'])=='') echo ' checked '?>/>默认
                    <input name="dbcharset" type="radio" id="dbcharset" value="gbk" <?php if(strtolower($CONFIG['dbcharset'])=='gbk') echo ' checked '?>/>GBK
					<input name="dbcharset" type="radio" id="dbcharset" value="big5" <?php if(strtolower($CONFIG['dbcharset'])=='big5') echo ' checked '?>/>big5 
					<input name="dbcharset" type="radio" id="dbcharset" value="utf8" <?php if(strtolower($CONFIG['dbcharset'])=='utf8') echo ' checked '?>/>utf8 
					<input name="dbcharset" type="radio" id="dbcharset" value="latin1" <?php if(strtolower($CONFIG['dbcharset'])=='latin1') echo ' checked '?>/>latin1 
<img src="images/help.gif" style="cursor:pointer;" alt="查看帮助" align="absmiddle" onclick="help('helpdbcharset','<br />如果Mysql版本为4.0.x，则请选择默认；<br />如果Mysql版本为4.1.x或以上，则请选择其他字符集（一般选GBK）。');" />
      <span id='helpdbcharset'></span>
					</td>
                  </tr>
				  <tr bgcolor="#ECE9DB">
                    <td align="right" class="tablerow"><strong>是否起用持久连接：</strong></td>
                    <td align="left" class="tablerow"><input name="pconnect" type="radio" id="pconnect" value="1" 
					<?php if($CONFIG['pconnect']==1) echo ' checked '?>/>是&nbsp;&nbsp;
					<input name="pconnect" type="radio" id="pconnect" value="0" 
					<?php if($CONFIG['pconnect']==0) echo ' checked '?>/>否
					<img src="images/help.gif" style="cursor:pointer;" alt="查看帮助" align="absmiddle" onclick="help('helppconnect','&nbsp;数据库连接上后不释放，保存一直连接状态，不使用则每次请求重新连接数据库');" /><span id='helppconnect'></span>
      <span id='helptablepre'></span></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="right" class="tablerow"></td>
                    <td align="left" class="tablerow">
                      <input type="button" name="check" value="数据库配置检测" onclick="javascript:dbcheck.location.href='?step=dbcheck&dbhost='+myform.dbhost.value+'&dbuser='+myform.dbuser.value+'&dbpw='+myform.dbpw.value+'&dbname='+myform.dbname.value+'&tablepre='+myform.tablepre.value"  class="btn" style="width:120px;height:25px" /></td>
                  </tr>
                  <iframe id="dbcheck" name="dbcheck" src="install/blank.html" width="0" height="0"></iframe>
                  <tr bgcolor="#ECE9DB">
                    <td align="right" class="tablerow"><strong>phpcms安装路径：</strong></td>
                    <td align="left" class="tablerow"><input name="rootpath" type="text" id="rootpath" value="<?=$rootpath?>" size="20" style="width:150px"/>  <img src="images/help.gif" style="cursor:pointer;"  alt="查看帮助" align="absmiddle" onclick="help('helprootpath','<br />相对于站点根目录的路径<br/>如果安装在根目录则填写 / ，如果安装在phpcms目录，则填写 /phpcms/');" />
					<span id='helprootpath'></span>
					</td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="right" class="tablerow"><strong>Cookie前缀：</strong></td>
                    <td align="left" class="tablerow"><input name="cookiepre" type="text" id="cookiepre" value="<?=$CONFIG['cookiepre']?>" size="20" style="width:150px"/>  <img src="images/help.gif" style="cursor:pointer;"  alt="查看帮助" align="absmiddle" onclick="help('helpcookiepre','<br />如果一个域名下安装多套phpcms，则请修改Cookie前缀');" />
					<span id='helpcookiepre'></span>
					</td>
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
                <input class="btn" name="dosubmit" type="submit" value="下一步(N)">
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
<?php include "./install/footer.tpl.php";?>