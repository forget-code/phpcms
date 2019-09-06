<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
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
    <th colspan=2>添加风格</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&save=1">
<tr>
<td class="tablerow" width="25%">选择风格所属方案</td>
<td class="tablerow">
<input type="hidden" name="module" value="<?=$module?>">
<select name="projectid">
<?php 
if(is_array($projects)){
	foreach($projects as $project){
            echo "<option value='".$project['projectid']."'>".$project['projectname']."</option>\n";
	}
}
?>
</select>
</td>
</tr>
<tr>
<td class="tablerow">选择风格目录</td>
<td class="tablerow">
<select name="skin">
<?php 
if(is_array($newskins)){
	foreach($newskins as $newskin){
            echo "<option value='".$newskin."'>".$newskin."</option>\n";
	}
}
?>
</select>
</td>
</tr>
<tr>
<td class="tablerow">风格名称（可以是中文）</td>
<td class="tablerow"><input size=40 name="skinname" type=text ></td>
</tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><input type="submit" name="submit" value=" 保存风格 "></td>
  </tr>
</table>
</form>
</body>
</html>