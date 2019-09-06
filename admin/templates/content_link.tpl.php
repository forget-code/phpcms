<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<script language='JavaScript' type='text/JavaScript'>
function CheckForm(){
	if(document.myform.catname.value==''){
		alert('请输入链接名称！');
		document.myform.catname.focus();
		return false;
	}
	if(document.myform.url.value==''){
		alert('请输入链接地址！');
		document.myform.url.focus();
		return false;
	}
}
</script>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&catid=<?=$catid?>" onSubmit='return CheckForm();'>
<input type="hidden" name="category[type]" value="<?=$type?>">
<table cellpadding="2" cellspacing="1" class="table_form">
  <caption>更新外部链接</caption>
    <tr>
      <th><strong>链接名称</strong></th>
      <td><input name='category[catname]' type='text' id='catname' value="<?=$catname?>" size='40' maxlength='50'> <?=form::style('category[style]', $style)?>  <font color="red">*</font></td>
    </tr>
    <tr>
      <th><strong>链接图片</strong></th>
      <td><input name='category[image]' type='text' id='image' value="<?=$image?>" size='40' maxlength='50'> <?=file_select('image', $catid, 1)?></td>
    </tr>
    <tr>
      <th><strong>链接地址</strong></th>
      <td><input name='category[url]' type='text' id='url' value="<?=$url?>" size='60' maxlength='100'>  <font color="red">*</font></td>
    </tr>
    <tr>
     <td></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
   </tr>
</table>
</form>
</body>
</html>