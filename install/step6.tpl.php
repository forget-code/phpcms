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
        <td  colspan="2" style="background:url('install/images/install_banner.jpg') no-repeat right;"><font color="#383F69"><strong>安装环境检测</strong></font><br>
<font color="#383F69">安装环境检测</font></td>
      </tr>
	  <tr>
        <td height="2" colspan="2" class="tr-bottom-bg"></td>
        <td width="470" height="2" class="tr-bottom-bg"></td>
	  </tr>
      <tr  class="tr-bottom">
        <td height="230" colspan="3">         
          <table width="100%" height="99%"  border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="12" rowspan="2">&nbsp;</td>
              <td height="28" colspan="3"> 检测您的服务器环境是否符合PHPCMS安装的基本要求，如通过请单击 [下一步(N)] 继续。                </td>
              </tr>
            <tr>
              <td colspan="3" valign="top">
			  <div style="height:200px;width:100%;background:#ECE9DB;overflow-y:auto;float:left;border:solid 1px #7F9DB9;">			  
			    <table width="100%" align="center" cellpadding="1" cellspacing="1"  cellspacing="1" bgcolor="#FFFFFF">
                  <tr align="center" bgcolor="#ECE9DB">
                    <td width="22%">检查项目</td>
                    <td width="29%">当前环境</td>
                    <td width="34%">建议环境</td>
                    <td width="15%">功能影响</td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="left">服务器操作系统</td>
                    <td align="left"><?=$PHP_OS?></td>
                    <td align="left">Windows_NT/Linux/Freebsd</td>
                    <td align="left"><font color="blue">支持phpcms</font></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="left">web服务器</td>
                    <td align="left"><?=$PHP_SERVER?></td>
                    <td align="left">IIS/Apache</td>
                    <td align="left"><font color="blue">支持phpcms</font></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="left">php</td>
                    <td align="left">php
                        <?=$PHP_VERSION?></td>
                    <td align="left">php 4.3.0 以上</td>
                    <td align="left"><?php if($PHP_VERSION >= '4.2.0'){ ?>
                        <font color="blue">支持phpcms
                        <?php }else{ ?>
                        <font color="red"><b>不支持phpcms</b></font>
                        <?php }?>
                      </font></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="left">zend optimizer</td>
                    <td align="left"><?php if($PHP_ZEND){ ?>
                      zend v
                        <?=$PHP_ZEND?>
                        <?php }else{ ?>
                        不支持
                        <?php }?></td>
                    <td align="left">zend optimizer 2.5.10以上</td>
                    <td align="left"><?php if($PHP_ZEND >= '2.5.10'){ ?>
                        <font color="blue">支持phpcms</font>
                        <?php }elseif(empty($PHP_ZEND)){ ?>
                        无法获得zend版本
                        <?php }else{ ?>
                        <font color="red"><b>不支持phpcms</b></font>
                        <?php }?></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="left">GD 库</td>
                    <td align="left"><?php if($PHP_GD){ ?>
                      支持
                        <?=$PHP_GD?>
                        <?php }else{ ?>
                        不支持
                        <?php }?></td>
                    <td align="left">建议开启</td>
                    <td align="left"><?php if($PHP_GD){ ?>
                        <font color="blue">无影响</font>
                        <?php }else{ ?>
                        <font color="red">不支持缩略图和水印</font>
                        <?php }?></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="left">Mb_string扩展</td>
                    <td align="left"><?php if($PHP_MBSTRING){ ?>
                      支持
                        <?php }else{ ?>
                        不支持
                        <?php }?></td>
                    <td align="left">建议开启</td>
                    <td align="left"><?php if($PHP_MBSTRING){ ?>
                        <font color="blue">无影响</font>
                        <?php }else{ ?>
                        <font color="red">影响字符集转换</font>
                        <?php }?></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="left">URL打开远程文件</td>
                    <td align="left"><?php if($PHP_FOPENURL){ ?>
                      支持
                        <?php }else{ ?>
                        不支持
                        <?php }?></td>
                    <td align="left">建议打开</td>
                    <td align="left"><?php if($PHP_FOPENURL){ ?>
                        <font color="blue">无影响</font>
                        <?php }else{ ?>
                        <font color="red">不支持保存远程图片</font>
                        <?php }?></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="left">服务器DNS解析</td>
                    <td align="left">
					<?php if($PHP_DNS){ ?>
                         支持
                    <?php }else{ ?>
                         不支持
                    <?php }?></td>
                    <td align="left">建议设置正确</td>
                    <td align="left">
					    <?php if($PHP_DNS){ ?>
                        <font color="blue">无影响</font>
                        <?php }else{ ?>
                        <font color="red">不支持采集和保存远程图片</font>
                        <?php }?></td>
                  </tr>
                  <tr bgcolor="#ECE9DB">
                    <td align="left">Safe mode(安全模式)</td>
                    <td align="left"><?php if($PHP_SAFEMODE){ ?>
                      开启
                        <?php }else{ ?>
                        禁用
                        <?php }?></td>
                    <td align="left">建议禁用</td>
                    <td align="left"><?php if($PHP_SAFEMODE){ ?>
                        <font color="red">影响html生成功能</font>
                        <?php }else{ ?>
                        <font color="blue">无影响</font>
                        <?php }?></td>
                  </tr>
                  
                </table>
		        
			  </div>
			  
			  </td>
              </tr>
          </table>		  </td>
        </tr>
	  <tr>
        <td height="2" colspan="4" class="tr-bottom-bg"></td>
	  </tr>
      <tr class="tr-bottom">
        <td height="27" colspan="3" align="right" valign="bottom">
		  <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td valign="top"><img src="install/images/installsystem.gif" width="183" height="12" align="top"></td>
              <td><div align="right">
                  <input class="btn" onClick="location.href='javascript: history.go(-1);'" type=reset value="上一步(P)" name=reset>
                 <input class="btn" name="dosubmit" type="submit" value="下一步(N)">
                  <input class="btn" onClick="CloseWindow();" type=reset value="取消(C)" name=reset1>
              </div></td>
            </tr>
          </table>
          &nbsp;&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</td>
  </tr>
</table>
<?php include PHPCMS_ROOT."/install/footer.tpl.php";?>