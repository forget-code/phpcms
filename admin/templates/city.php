<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>

<form name="myform" method="post" action="?mod=phpcms&file=city">

<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="6"><?=$province?>管理</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight">选中</td>
<td class="tablerowhighlight">序号</td>
<td class="tablerowhighlight">市/区</td>
<td class="tablerowhighlight">区/县</td>
<td class="tablerowhighlight">邮编</td>
<td class="tablerowhighlight">区号</td>
</tr>
<?php 
	foreach($citys as $id=>$city)
	{ 
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><input type="checkbox" name="delete[<?=$id?>]" id="cityid<?=$id?>" value="1" /></td>
<td align="center"><?=$id?></td>
<td align="center"><input type="text" name="city[<?=$id?>]" value="<?=$city['city']?>" size="20"></td>
<td align="center"><input type="text" name="area[<?=$id?>]" value="<?=$city['area']?>" size="20"></td>
<td align="center"><input type="text" name="postcode[<?=$id?>]" value="<?=$city['postcode']?>" size="10"></td>
<td align="center"><input type="text" name="areacode[<?=$id?>]" value="<?=$city['areacode']?>" size="10"></td>
</tr>
<?php 
	}
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><input type="hidden" name="newcountry" value="中华人民共和国"><input type="hidden" name="newprovince" value="<?=$province?>"></td>
<td align="center">增加：</td>
<td align="center"><input type="text" name="newcity" size="20"></td>
<td align="center"><input type="text" name="newarea" size="20"></td>
<td align="center"><input type="text" name="newpostcode" size="10"></td>
<td align="center"><input type="text" name="newareacode" size="10"></td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="35%">
	<input name='chkall' title="全部选中" type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox' /> 全选/不选
	</td>
	<td>
	<input name="submit" type="submit" value=" 更新省市信息 " />
	</td>
  </tr>
</table>
</form>

</body>
</html>