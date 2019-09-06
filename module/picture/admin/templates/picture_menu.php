<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?php
if ($action==manage||$action==mypicture||$action==check||$action==recycle){
switch($srchtype){
case '0':
$a="selected";
break;

case '1':
$b="selected";
break;

case '2':
$c="selected";
break;

case '3':
$d="selected";
break;
}

switch($ordertype){
case '1':
$e="selected";
break;

case '2':
$f="selected";
break;

case '3':
$g="selected";
break;

case '4':
$h="selected";
break;
}
if($elite){
$j="checked";
}
if($ontop){
$k="checked";
}

echo "
<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"tableBorder\">
<form method=\"get\" name=\"search\" action=\"?\">
  <tr>
    <td height=\"30\" class=\"tablerow\" align=\"center\">
	<input name=\"mod\" type=\"hidden\" value=".$mod.">
	<input name=\"file\" type=\"hidden\" value=".$file.">
	<input name=\"action\" type=\"hidden\" value=".$action.">
	<input name=\"status\" type=\"hidden\" value=".$status.">
	<input name=\"channelid\" type=\"hidden\" value=".$channelid.">
	<input name=\"catid\" type=\"hidden\" value=".$catid.">
	<select name=\"srchtype\">
	<option value=\"0\" ".$a."> 标题 </option>
	<option value=\"1\" ".$b."> 内容 </option>
	<option value=\"2\" ".$c."> 作者 </option>
	<option value=\"3\" ".$d."> 会员 </option>
	</select>
	<input name=\"keywords\" type=\"text\" size=\"50\" value=".$keywords.">&nbsp;
	<select name=\"catid\">
	<option value=\"0\">请选择栏目</option>
	".$cat_option."
	</select>
	<input type=\"checkbox\" class=\"radio\" name=\"elite\" value=\"1\" ".$j." > 推荐
	<input type=\"checkbox\" class=\"radio\" name=\"ontop\" value=\"1\" ".$k."> 置顶
	<select name=\"ordertype\">
	<option value=\"1\" ".$e.">更新时间降序</option>
	<option value=\"2\" ".$f.">更新时间升序</option>
	<option value=\"3\" ".$g.">浏览次数降序</option>
	<option value=\"4\" ".$h.">浏览次数升序</option>
	</select>
	<input name=\"submit\" type=\"submit\" value=\"图片搜索\"></td>
  </tr>
</form>
</table>";
}
?>