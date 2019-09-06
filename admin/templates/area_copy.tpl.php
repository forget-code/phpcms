<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>
<script type="text/javascript">
function check()
{
	if(!$('batchareaid').value)
	{
		alert('请选择源地区');
		return false;
	}
	if(!$('tokeyid').value)
	{
		alert('请选择目标频道');
		return false;
	}
	if(confirm('提示:此操作不能直接继承源地区的上下级关系\n\n如需要继承上下级关系，请先复制父栏目至目标频道\n\n成功后再复制其子栏目至目标频道对应父栏目\n\n确定提交吗？'))
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=3>地区分类复制</th>
  </tr>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&keyid=<?=$keyid?>&dosubmit=1"  onsubmit="return check();">
<tr>
<td class="tablerow" valign="top"  width="45%">

<table width="100%" cellpadding="3" cellspacing="2">
<tr>
<td>源地区:(<font color="red">Tips:</font>源地区可按Ctrl键多选)</td>
</tr>
<tr>
<td>
<select name="batchareaid[]" size="2" multiple style="height:300px;width:350px;" id="batchareaid">
<?=$area_select?>
</td>
</tr>
</table>

</td>
<td align="center" class="tablerow" width="10%"> &gt;&gt;</td>
<td class="tablerow" valign="top"  width="45%">

<script type="text/javascript">
function getareas(keyid)
{
    var url ="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&keyid=<?=$keyid?>";
    var pars = "request_keyid="+keyid;
	var cAjax = new Ajax.Request(url, {method: 'get', parameters: pars, onComplete: intext});
}

function intext(Request)
{
	var text = Request.responseText;
	$('areaselect').innerHTML = text;
}
</script>
	<table width="100%" cellpadding="3" cellspacing="2">
	<tr>
	<td>
	复制到:<select name='tokeyid' onchange="if(this.value){getareas(this.value);}" id='tokeyid'>
	<option>目标频道</option>
	<?php 
	foreach($CHANNEL as $id=>$channel)
	{
		if($channel['module'] != $mod || $channel['islink'] || $id == $keyid) continue;
	?>
			<option value='<?=$id?>'><?=$channel['channelname']?></option>
	<?php 
	}
	?>
	</select>
	</td>
	</tr>
	<tr>
	<td id="areaselect">
	<select name="targetareaid" size="2" style="height:300px;width:350px;"><option selected>新建地区</option></select>
	</td>
	</tr>
	</table>
</div>
</td>
</tr>
</tbody>
<tr align="center">
<td class="tablerow"></td>
<td class="tablerow"><input type="submit" value=" 复 制 "></td>
<td class="tablerow"></td>
</tr>
</form>
</table>

</body>
</html>