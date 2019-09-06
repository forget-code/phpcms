<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script language="javascript">
     var i=<?=$i?>;
	 var k=i;
     function AddItem()
     { 
        i++;
		if(i>50)
		{
			alert("参数过多！");
			return;
		}
        document.all.setting.innerHTML+="<div id='setting"+i+"'><table cellpadding='0' cellspacing='0' border='0' width='100%'><tr align='center'><td class='tablerow' width='5%'>"+i+"</td><td class='tablerow' width='12%'><input name='myvariable[]' type='text' id='myvariable[]' size='12' maxlength='50'></td><td class='tablerow' width='34%'><textarea id='myvalue[]' name='myvalue[]' rows='3' cols='45'></textarea></td><td class='tablerow' width='25%'><textarea id='mynote[]' name='mynote[]' rows='3' cols='30'></textarea></td><td class='tablerow' width='15%'><input type='button' value=' 删除 ' name='del' onClick=\"DelItem('setting"+i+"');\"></td><td class='tablerow' width='5%'></td></tr></table></div>";
     }
	 function DelItem(myid)
	 {
		 i--;
		 setidval(myid,'');
	 }
	function ResetItem()
    { 
		document.all.setting.innerHTML= old;
		i=k;
    }
</script>

<body onload="old = document.all.setting.innerHTML">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6><?=$_MODULE[$module]['modulename']?>模块配置</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=setting&module=<?=$module?>&save=1">
<tr align="center">
<td width="5%" class="tablerowhighlight">序号</td>
<td width="12%" class="tablerowhighlight">参数名</td>
<td width="34%" class="tablerowhighlight">参数值</td>
<td width="25%" class="tablerowhighlight">参数说明</td>
<td width="15%" class="tablerowhighlight">变量名</td>
<td width="5%" class="tablerowhighlight">删除</td>
</tr>
<tr align="center" bgColor='#F1F3F5'>
<td colspan=6>
<div id="setting">
<?php 
if(is_array($settings)){
	$k=1;
	foreach($settings as $id => $setting){
?>
<div id="setting<?=$k?>">
     <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr align='center'> 
            <td class="tablerow" width="5%"><?=$k?></td>
            <td class="tablerow" width="12%">
			<?=$setting['variable']?>
			<input name="myvariable[<?=$setting['variable']?>]" type="hidden" id="myvariable[<?=$setting['variable']?>]" size="12" maxlength="50" value="<?=$setting['variable']?>" readonly>
			</td>
            <td class="tablerow" width="34%"><textarea id="myvalue[<?=$setting['variable']?>]" name="myvalue[<?=$setting['variable']?>]" rows="3" cols="45"><?=$setting['value']?></textarea></td>
            <td class="tablerow" width="25%" align="left" >
			<?=$setting['note']?>
			<input name="mynote[<?=$setting['variable']?>]" type="hidden" id="mynote[<?=$setting['variable']?>]" size="12" maxlength="50" value="<?=$setting['note']?>">
	        </td>
			<td class="tablerow" width="15%">$_PHPCMS['<?=$setting['variable']?>']</td>
			<td class="tablerow" width="5%">
			<input type="checkbox" value="<?=$setting['variable']?>" name="delete[<?=$setting['variable']?>]">
	        </td>
          </tr>
      </table>
</div>
<?php 
	$k++;
	}
}
?>
</div>
</td>
</tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<input type="submit" name="submit" value=" 保存配置 ">
	<input type="button" value="增加参数" name="add" onClick="AddItem();">
    <input type="button" value="重置参数" name="reset" onClick="ResetItem();">
	</td>
  </tr>
</table>
</form>
</body>
</html>