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
	  <table height="300"  border="0"  align="center" cellpadding="0" cellspacing="0" class="btable">
  <tr>
    <td><table  border="0" align="center" cellpadding="2" cellspacing="0" class="ltable">
      <tr>
        <td height="56" colspan="2"  style="background:url('install/images/install_banner.jpg') no-repeat right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#383F69"><strong> 最终用户许可证协议</strong></font><br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#383F69">请检阅授权条款</font></td>
        </tr>
	  <tr>
        <td width="186" height="2" class="tr-bottom-bg"></td>
        <td width="606" height="2" class="tr-bottom-bg"></td>
	  </tr>
      <tr  class="tr-bottom">
        <td height="230" colspan="2">         
          <table width="100%" height="230"  border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="19" rowspan="3">&nbsp;</td>
              <td width="455" height="25"> 请阅读许可证协议，拖动下拉条查看更多</td>
              <td width="18" rowspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td><textarea name="textfield" cols="48" rows="10" wrap="VIRTUAL" class="textarea" readonly><?php echo $license?></textarea></td>
              </tr>
            <tr>
              <td height="34">如果您接受协议重的条款，单击 [接受(I)] 继续安装。如果您选定 [取消(C)] ，安装程序将会关闭。安装<?php echo $PHPCMS_VERSION_NAME;?>必须接收该协议。 </td>
              </tr>
          </table>          </td>
        </tr>
	  <tr>
        <td height="2" colspan="3" class="tr-bottom-bg"></td>
	  </tr>
      <tr class="tr-bottom">
        <td align="right" valign="top"><img src="install/images/installsystem.gif" width="183" height="12" align="top">&nbsp;&nbsp;</td>
        <td align="right"><input class="btn" onClick="location.href='javascript: history.go(-1);'" type=reset value="上一步(P)" name=reset>
          <input class="btn" onClick="location.href='install.php?step=<?=++$step?>'" type=reset value="接受(I)" name=reset>
          <input class="btn" onClick="CloseWindow();" type=reset value="取消(C)" name=reset1>&nbsp;&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table></td>
  </tr>
</table>
<?php include PHPCMS_ROOT."/install/footer.tpl.php";?>