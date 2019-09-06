<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<script LANGUAGE="javascript">
<!--
function Check() {
	if ($('typeid').value==0)
	{
	  alert("请选择所属分类");
	  $('typeid').focus();
	  return false;
	 }
	if ($('name').value=="")
	{
	  alert("请输入网站名称");
	  $('name').focus();
	  return false;
	 }
	if ($('url').value=="")
	{
	  alert("请输入网站地址");
	  $('url').focus();
	  return false;
	 }
	if ($('url').value=="http://")
	{
	  alert("请输入网站地址");
	  $('url').focus();
	  return false;
	}
     return true;
}
//-->
</script>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>编辑友情链接</th>
  </tr>
<form method="post" name="myform" onsubmit="return Check()" action="?mod=link&file=link&action=<?=$action?>">
<tr >
	<td class="tablerow" align="right" valign="middle">所属分类</td>
	<td class="tablerow">
	<?=type_select('typeid','请选择分类',$typeid)?>
	</td>
</tr>
<tr >
	<td class="tablerow" align="right">链接类型</td>
	<td class="tablerow">
	<input name="linktype" type="radio" value="1" style="border:0" <?php if($linktype) echo 'checked="checked"'; ?>>
	Logo链接&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="linktype" type="radio" value="0"  style="border:0" <?php if(!$linktype) echo 'checked="checked"'; ?>>
	文字链接</td>
</tr>

<tr >
	<td class="tablerow" align="right" valign="middle">网站名称</td>
	<td class="tablerow"><input name="name" size="30"  maxlength="20" value="<?=$name?>">
	<font color="#FF0000"> *</font> &nbsp;<?=$style_edit?></td>
</tr>
<tr >
	<td class="tablerow" align="right">网站地址</td>
	<td class="tablerow"><input name="url" size="30"  maxlength="100" type="text" value="<?=$url?>">
	<font color="#FF0000">*</font></td>
</tr>
<tr >
	<td class="tablerow" align="right">网站Logo</td>
	<td class="tablerow"><input name="logo" size="30"  maxlength="100" type="text" id="logo" value="<?=$logo?>"> 大小规格为88*31像素
	<input type="button" value=" 上传 " onclick="javascript:openwinx('?mod=link&file=uppic&uploadtext=logo&width=88&height=31','upload','400','200')">
	</td>
</tr>
<tr>
	<td class="tablerow" align="right" >站长姓名</td>
	<td class="tablerow"><input name="username" size="30"  maxlength="20" type="text" value="<?=$username?>">
	可不填</td>
</tr>
<tr >
	<td class="tablerow" align="right">网站介绍</td>
	<td valign="middle" class="tablerow"><textarea name="introduce" cols="40" rows="5" id="introduction"><?=$introduce?></textarea></td>
</tr>
<tr >
	<td class="tablerow" align="right">推荐</td>
	<td class="tablerow"><input type='radio' name='elite' value='1' <?php if($elite) echo 'checked="checked"'; ?>> 是 <input type='radio' name='elite' value='0' <?php if(!$elite) echo 'checked="checked"'; ?>> 否</td>
</tr>

<tr>
	<td class="tablerow" align="right">批准</td>
	<td class="tablerow"><input type='radio' name='passed' value='1' <?php if($passed) echo 'checked="checked"'; ?>> 是 <input type='radio' name='passed' value='0' <?php if(!$passed) echo 'checked="checked"'; ?>> 否</td>
</tr>

<tr >
	<td class="tablerow" align="right"></td>
	<td class="tablerow">
	<input type="hidden" value="<?=$linkid?>" name="linkid">
	<input type="hidden" value="<?=$forward?>" name="forward">
	<input type="submit" value=" 确定 " name="submit">
	<input type="reset" value=" 清除 " name="reset">
	</td>
</tr>
       </form>
      </table>
</body>
</html>
