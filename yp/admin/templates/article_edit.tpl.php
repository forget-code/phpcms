<?php 
defined('IN_ADMIN') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<script type="text/javascript">
var laststring = "";
function segment_word(obj)
{
	if(obj.value == "" || obj.value == laststring)
	{
		return false;
	}
	laststring = obj.value;
	document.myframe_form.string.value = obj.value;
	document.myframe_form.submit();
	return true;
}
</script>
<iframe id="myframe" name="myframe" width="0" height="0"></iframe>
<form name="myframe_form" action="<?=PHPCMS_PATH?>segment_word.php" method="get" target="myframe">
<input type="hidden" name="string" />
<input type="hidden" name="action" value="get_keywords" />
<input type="hidden" name="charset" value="gbk" />
</form>
<form action="" method="post" name="myform" >
<BR>
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=3>信息添加</th>
 <tr> 
      <td width="19%" class="tablerow">所属栏目</td>
      <td class="tablerow"><font color="#FF0000"><?=$categorys?></font> </td>
    </tr>
<tr> 
	<td class="tablerow">标题</td>
	<td class="tablerow"><input name="article[title]" type="text" id="title" size="44" maxlength="100" class="inputtitle" onBlur="segment_word(this);" value="<?=$title?>"> <font color="#FF0000">*</font> <?=$style_edit?> <input type="button" value="检查同名标题" onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checktitle&title='+$('title').value+'','','300','40','no')" style="width:90px;">
	</td>
</tr>
<tr>

      <td class="tablerow">关键字</td>
      <td class="tablerow"><input name="article[keywords]" type="text" id="keywords" size="40" title="提示;多个关键字请用半角逗号“,”隔开" value="<?=$keywords?>">
</td>
</tr>
<tr> 
	<td class="tablerow">标题图片</td>
		<td class="tablerow" title="如果设置产品图片，则可以在首页以及栏目页以图片方式链接到产品"><input name="article[thumb]" type="text" id="thumb" size="53">  <input type="button" value="上传图片" onclick="javascript:openwinx('<?=PHPCMS_PATH?>upload.php?keyid=yp&uploadtext=thumb&type=thumb&width=150&height=150','upload','350','350')">
	</td>
</tr>
<tr> 
<td class="tablerow">内容</td>
<td valign="top" class="tablerow">
<textarea name="article[content]" id="content" cols="100" rows="25"><?=$content?></textarea> <?=editor("content", 'phpcms','100%','400')?>
</td>
</tr>
<tr> 
	<td class="tablerow">信息状态</td>
	<td class="tablerow">

	<input name="article[status]" type="radio" value="3" <?php if($_groupid<4){?>checked<?php }else{ ?>disabled<?php } ?>> 已通过&nbsp;
	<input name="article[status]" type="radio" value="1" <?php if($_groupid==4){?>checked<?php } ?>> 待审核&nbsp;
	<input name="article[status]" type="radio" value="0"> 草稿&nbsp;
	</td>
</tr>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <td width="15%" class="tablerow">
	</td>
    <td class="tablerow" height="25">
	<input type="hidden" name="articleid" value="<?=$articleid?>" />
	<input type="hidden" name="forward" value="<?=$forward?>" />
	<input type="submit" name="dosubmit" value=" 确认修改 " />
	</td>
  </tr>
</table>
</form>
</body>
</html>