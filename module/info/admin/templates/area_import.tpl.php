<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<script type="text/javascript">
function slt(k,v)
{
	var t = <?php echo count($provinces);?>;
	for(var i=1;i<=t;i++)
	{
		if($(k+'_'+v+'_'+i) == null) continue;
		if(v==1)
		{
			$(k+'_1_'+i).checked=true;$(k+'_0_'+i).checked=false;
		}
		else
		{
			$(k+'_0_'+i).checked=true;$(k+'_1_'+i).checked=false;
		}
	}
}
</script>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>">
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="4">省/市数据导入</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight">省/市</td>
<td class="tablerowhighlight">是否导入省/市</td>
<td class="tablerowhighlight">是否导入市/区</td>
</tr>
<tr align="center">
<td class="tablerow"> </td>
<td class="tablerow">
<a href="javascript:slt('p',1)">全选是</a>
<a href="javascript:slt('p',0)">全选否</a>
</td>
<td class="tablerow">
<a href="javascript:slt('c',1)">全选是</a>
<a href="javascript:slt('c',0)">全选否</a>
</td>
</tr>
<?php 
	foreach($provinces as $id=>$province)
	{ 
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><input size="14" value="<?=$province['province']?>" name="provinces[<?=$id?>]"></td>
<td align="center">
<input type="radio" name="province[<?=$id?>]" value="1" id="p_1_<?=$id?>"/>
是
<input type="radio" name="province[<?=$id?>]" value="0" checked id="p_0_<?=$id?>"/>
否
</td>
<td align="center">
<input type="radio" name="city[<?=$id?>]" value="1" id="c_1_<?=$id?>"/>
是
<input type="radio" name="city[<?=$id?>]" value="0" checked id="c_0_<?=$id?>"/>
否
</td>
<!--<td align="center"><input type="checkbox" name="area[<?=$id?>]" value="1" /></td>-->
</tr>
<?php 
	}
?>
<tr align="center">
<td class="tablerow">  </td>
<td class="tablerow">
<a href="javascript:slt('p',1)">全选是</a>
<a href="javascript:slt('p',0)">全选否</a>
</td>
<td class="tablerow">
<a href="javascript:slt('c',1)">全选是</a>
<a href="javascript:slt('c',0)">全选否</a>
</td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="35%">
	</td>
	<td>
	<input name="dosubmit" type="submit"  value=" 导入省市信息 " />
	</td>
  </tr>
</table>
</form>
</body>
</html>