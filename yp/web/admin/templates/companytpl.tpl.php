<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<BR>
<form name="myform" method="post" action="">
<table width="100%"  cellpadding="2" cellspacing="1" class="tableborder">
 <th colspan=3>选择模板</th>
<?php
$i=0;
foreach($companytpl_config AS $k=>$v)
{
	$groupid = '';
	$groupid = $companytpl_config[$k]['groupid'];
	//$_groupid = '1';//用户所在的用户组
	if(strpos($groupid,$_groupid) === false) continue;
	$thumb = $PHPCMS['siteurl'].$companytpl_config[$k]['thumb'];
	$filename = $companytpl_config[$k]['filename'];
	$defaulttpl = $defaultTplType;
	if($defaulttpl == $filename)
	{
		$checked = 'checked="checked"';
	}
	else
	{
		$checked = '';
	}

	if($i%6==0)	echo "<tr align='center'>";
	if($MSIE)
	{
		echo "<td class='tablerow' onclick=\"$('showpic').innerHTML='<BR><table width=100%  cellpadding=2 cellspacing=1 class=tableborder> <th>模板预览</th><tr align=center><td class=tablerow><img src=$thumb></td></tr></table>';\">";
		echo $k."<input type='radio' name='tpl' $checked value='$filename'>";

	}
	else
	{
		echo "<td class='tablerow'><a href='$thumb' target='_blank' title='预览效果图'>$k</a>";
		echo "<input type='radio' name='tpl' $checked value='$filename'>";

	}
	echo "</td>";
	if($i%6==5) echo "</tr>";

$i++;
}
?>
</table>
<div id="showpic"></div>
<BR>
<table width="100%"  cellpadding="2" cellspacing="1" class="tableborder">

<tr>
<td valign="top" colspan=2 class="tablerowhighlight">
企业主页背景模式
</td>
</tr>
<tr>
<td valign="top" colspan=2 class="tablerow">
默认<input type="radio" name="backgroundmode" value="0" onclick="$('backid').style.display='none';$('colorid').style.display='none'" <?php if(!$backgroundmode) echo "checked"; ?>> &nbsp;&nbsp;&nbsp;背景图片<input type="radio" name="backgroundmode" value="1" onclick="$('backid').style.display='block';$('colorid').style.display='none'" <?php if($backgroundmode==1) echo "checked"; ?>> &nbsp;&nbsp;&nbsp;颜色<input type="radio" name="backgroundmode" value="2" onclick="$('backid').style.display='none';$('colorid').style.display='block'" <?php if($backgroundmode==2) echo "checked"; ?>>
</td>
</tr>
<tr id="backid" <?php if($backgroundmode==1) echo "style='display:block'"; else echo "style='display:none'";?>> 
	<td class="tablerow" width="10%">图片地址</td>
	<td class="tablerow" height="22"><input name="background" type="text" id="background" size="53" value="<?=$backgroundimg?>"><input type="button" value="上传图片" onclick="javascript:openwinx('<?=$SITEURL?>/upload.php?keyid=yp&uploadtext=background&type=thumb&width=780&height=698','upload','350','350')">
	</td>
</tr>
<tr id="colorid" <?php if($backgroundmode==2) echo "style='display:block'"; else echo "style='display:none'";?>> 
	<td class="tablerow" width="10%">颜色选择</td>
		<td class="tablerow" >
<OBJECT id="colorselect" CLASSID="clsid:3050f819-98b5-11cf-bb82-00aa00bdce0b" WIDTH="0px" HEIGHT="0px"></OBJECT>
<input name="color" style='width:64px;cursor:hand;10px;background-color:<?=$backgroundcolor?>;color:#ffffff;' id='color' onclick="pickColor()" value="<?=$backgroundcolor?>" onblur="this.style.backgroundColor=this.value;window.color=this.value.replace('#','');" maxlength="7"/>
	</td>
</tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0" >
  <tr>
     <td width='40%' ></td>
     <td ><input type="submit" name="dosubmit" value=" 下一步 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>

<script type="text/javascript">
<!--
function pickColor()
{
	var sColor = $('colorselect').ChooseColorDlg();
	var color = sColor.toString(16);
	while (color.length<6) color="0"+color;
	window.color = color;
	color = "#"+color;
	$('color').style.backgroundColor = color;
	$('color').value = color;
}

var isIE = (document.all && window.ActiveXObject) ? true : false;
//-->
</script>
</body>
</html>