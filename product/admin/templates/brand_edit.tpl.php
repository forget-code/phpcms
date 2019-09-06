<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script language='JavaScript'>
function CheckForm()
{
	if($F('brand_name')=='')
	{
		alert('请填写品牌名称！');
		$('brand_name').focus();
		return false;
	}
}
function SelectPic(){
  var arr=Dialog('?mod=<?=$mod?>&file=file_select&type=thumb','',700,500);
  if(arr!=null){
    var s=arr.split('|');
    $('brand_icon').value=s[0];
  }
}
</script>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>编辑品牌属性</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit" name="myform">
<input type="hidden" name='brand_id' value="<?=$brand_id?>" />
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="25%" class="tablerow">品牌名称：</td>
<td class="tablerow"  align="left"><input type="text" name="brand[brand_name]" id="brand_name" size="25" value="<?=$brand['brand_name']?>"/>&nbsp;<font color="Red">*</font></td>
</tr>

<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td width="25%" class="tablerow">品牌图标：</td>
<td class="tablerow" align="left"><input type="text" name="brand[brand_icon]" id="brand_icon" size="35" value="<?=$brand['brand_icon']?>"/>
<input type="button" value="上传图标" onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=brand_icon&width=<?=$MOD['thumbwidth']?>&height=<?=$MOD['thumbheight']?>','upload','350','350')">
	   <input name="fromupload" type="button" id="fromupload" value=" 从已经上传的图片中选择 " onclick='SelectPic()'/>
	   </td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td width="25%" class="tablerow">使用频度：</td>
<td class="tablerow" align="left"><input type="text" name="brand[brand_frequency]" id="brand_frequency" size="35" value="<?=$brand['brand_frequency']?>"/></td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="25%" class="tablerow">品牌描述：</td>
<td class="tablerow" align="left"><textarea name='brand[brand_description]' id='brand_description' rows='4' cols='40'><?=$brand['brand_description']?></textarea></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><input name="submit" type="submit" size="4" value="确定" onclick="return CheckForm();"></td>
  </tr>
</table>
</form>
</body>
</html>