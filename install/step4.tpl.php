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
    <td><table border="0" align="center" cellpadding="2" cellspacing="0"  class="ltable">
      <tr>
        <td height="56"  colspan="3" style="background:url('install/images/install_banner.jpg') no-repeat right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#383F69"><strong>选择安装模块</strong></font><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#383F69">请选择您需要安装的模块</font></td>
      </tr>
	  <tr>
        <td height="2" colspan="2" class="tr-bottom-bg"></td>
        <td width="470" height="2" class="tr-bottom-bg"></td>
	  </tr>
      <tr  class="tr-bottom">
        <td height="260" colspan="3">         
          <table width="100%"  border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="12" rowspan="4">&nbsp;</td>
              <td height="13" colspan="3"> 勾选您需要安装模块，并且解除勾选您不需要安装的模块，单击 [下一步(N)] 继续。                </td>
              </tr>
            <tr>
              <td width="111" height="20" valign="top">选择安装模块</td>
              <td width="180" rowspan="3" valign="top">
			  <div style="height:230px;width:170px;background:#FFFFFF;overflow-y:auto;float:left;border:solid 1px #7F9DB9;">
			 
			  

<table width="150" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr><td><img src="install/images/nodestart.gif" border="0" align="absmiddle" /><input type="checkbox" name="phpcms" value="checkbox" checked disabled><span class="disabletxt">PHPCMS主框架</span></td></tr>
<tr><td><img src="install/images/node.gif" border="0" align="absmiddle" /><input type="checkbox" name="member" value="checkbox" checked  disabled><span class="disabletxt">会员模块</span></td></tr>
<tr><td> <a href="#" onClick="opentree('openchannel')"><img src="install/images/opn1.gif" border="0"  id="tree1" align="absmiddle"/>可复制频道</a></td>
</tr>
</tbody>
<tbody style="display:block;" id="openchannel">
<?php
$count = count($PHPCMS_CHANNELS['name']);
foreach($PHPCMS_CHANNELS['name'] as  $i=>$channel)
{
if($i == $count-1)
{
?>
<tr onmouseout="this.style.backgroundColor='#FFFFFF';document.getElementById('introducetd').style.color='#ACA899';document.getElementById('introducetd').innerHTML='移动鼠标指针查看相应模块的描述';" onmouseover="this.style.backgroundColor='#BFDFFF';showdescription('<?=addslashes($PHPCMS_CHANNELS['introduce'][$i])?>');"><td><img src="install/images/opnend.gif" border="0" align="absmiddle" /><input type="checkbox" name="selectchannel[<?=$channel?>]" value="<?=$channel?>" checked><?=$PHPCMS_CHANNELS['modulename'][$i]?>频道</td></tr>
<?php
}
else 
{
?>
<tr onmouseout="this.style.backgroundColor='#FFFFFF';document.getElementById('introducetd').style.color='#ACA899';document.getElementById('introducetd').innerHTML='移动鼠标指针查看相应模块的描述';" onmouseover="this.style.backgroundColor='#BFDFFF';showdescription('<?=addslashes($PHPCMS_CHANNELS['introduce'][$i])?>');"><td><img src="install/images/opn.gif" border="0" align="absmiddle" /><input type="checkbox" name="selectchannel[<?=$channel?>]" value="<?=$channel?>" checked><?=$PHPCMS_CHANNELS['modulename'][$i]?>频道</td></tr>
<?php
}
}
?>
</tbody>
<tbody>
<tr><td><a href="#" onClick="opentree('openmodule')"><img src="install/images/opn2.gif" border="0" id="tree2" align="absmiddle" />功能模块</a></td>
</tr>
</tbody>
<tbody style="display:block;" id="openmodule">
<?php
$count = count($PHPCMS_MODULES['name']);
foreach($PHPCMS_MODULES['name'] as  $i=>$module)
{
if($i == $count-1)
{
?>
<tr onmouseout="this.style.backgroundColor='#FFFFFF';document.getElementById('introducetd').style.color='#ACA899';document.getElementById('introducetd').innerHTML='移动鼠标指针查看相应模块的描述';" onmouseover="this.style.backgroundColor='#BFDFFF';showdescription('<?=addslashes($PHPCMS_MODULES['introduce'][$i])?>');"><td><img src="install/images/mopnend.gif" border="0" align="absmiddle" /><input type="checkbox" name="selectmod[<?=$module?>]" value="<?=$module?>" checked><?=$PHPCMS_MODULES['modulename'][$i]?>模块</td></tr>
<?php
}
else 
{
?>
<tr onmouseout="this.style.backgroundColor='#FFFFFF';document.getElementById('introducetd').style.color='#ACA899';document.getElementById('introducetd').innerHTML='移动鼠标指针查看相应模块的描述';" onmouseover="this.style.backgroundColor='#BFDFFF';showdescription('<?=addslashes($PHPCMS_MODULES['introduce'][$i])?>');"><td><img src="install/images/mopn.gif" border="0" align="absmiddle" /><input type="checkbox" name="selectmod[<?=$module?>]" value="<?=$module?>" checked><?=$PHPCMS_MODULES['modulename'][$i]?>模块</td></tr>
<?php
}
}
?>
</tbody>
</table>

			  
			  </div></td>
              <td width="189" valign="top"><span class="style1"><strong>描述</strong></span></td>
            </tr>
            <tr valign="top">
              <td width="111" height="76" valign="top">&nbsp;</td>
              <td rowspan="2" valign="top" class="disabletxt" id='introducetd'>移动鼠标指针查看相应模块的描述</td>
            </tr>
            <tr valign="top">
              <td height="116" valign="top">
			  该版本可供选择安装<br><br>
			  系统必备模块：2个<br>
              可复制频道：<?=count($PHPCMS_CHANNELS['name'])?>个<br>
              功能模块：<?=count($PHPCMS_MODULES['name'])?>个</td>
              </tr>
          </table>
		  </td>
        </tr>
	  <tr>
        <td height="2" colspan="4" class="tr-bottom-bg"></td>
	  </tr>
      <tr class="tr-bottom">
        <td height="25" colspan="2" align="right" valign="top">
		&nbsp;<img src="install/images/installsystem.gif" width="183" height="12" align="top">&nbsp;</td>
        <td height="25" align="right"><input class="btn" onClick="location.href='javascript: history.go(-1);'" type=reset value="上一步(P)" name=reset>
          <input class="btn" name="dosubmit" type="submit" value="下一步(N)">
          <input class="btn" onClick="CloseWindow();" type=reset value="取消(C)" name=reset1></td>
      </tr>
    </table></td>
  </tr>
</table>

</form>
</td>
  </tr>
</table>
<?php include "./install/footer.tpl.php";?>