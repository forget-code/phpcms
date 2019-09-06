<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
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
function CheckForm()
{
	if ($('catid').value=='0'){
	alert('请选择栏目');
	$('catid').focus();
	return false;
	}
	if ($F('title') == "")
	{
	alert("标题不能为空！")
	Field.clear('title')
	Field.focus('title');
	return false
	}

}
</script>
<iframe id="myframe" name="myframe" width="0" height="0"></iframe>
<form name="myframe_form" action="<?=$SITEURL?>/segment_word.php" method="get" target="myframe">
<input type="hidden" name="string" />
<input type="hidden" name="action" value="get_keywords" />
<input type="hidden" name="charset" value="gbk" />
</form>
<form action="" method="post" name="myform" onSubmit='return CheckForm();'>

<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=3>新闻发布</th>
 <tr> 
      <td width="19%" class="tablerow">所属栏目</td>
      <td class="tablerow"><font color="#FF0000"><?=trade_select('article[catid]', '请选择所属栏目','',"id='catid'")?></font> </td>
    </tr>
<tr> 
	<td class="tablerow">标题</td>
	<td class="tablerow"><input name="article[title]" type="text" id="title" size="44" maxlength="100" class="inputtitle" onBlur="segment_word(this);"> <font color="#FF0000">*</font> <?=$style_edit?>
	</td>
</tr>
<tr>

      <td class="tablerow">关键字</td>
      <td class="tablerow"><input name="article[keywords]" type="text" id="keywords" size="40" title="提示;多个关键字请用半角逗号“,”隔开">
</td>
</tr>
<tr> 
	<td class="tablerow">标题图片</td>
		<td class="tablerow" title="如果设置产品图片，则可以在首页以及栏目页以图片方式链接到产品"><input name="article[thumb]" type="text" id="thumb" size="53">  <input type="button" value="上传图片" onclick="javascript:openwinx('<?=$SITEURL?>/upload.php?keyid=yp&uploadtext=thumb&type=thumb&width=150&height=150','upload','350','350')">
	</td>
</tr>
<tr> 
<td class="tablerow">内容</td>
<td valign="top" class="tablerow">
<textarea name="article[content]" id="content" cols="100" rows="25"></textarea><?=editor("content", 'phpcms','100%','400')?>
</td>
</tr>
<?php if(!$arrgroupidpost) {?>
<tr> 
	<td class="tablerow">信息状态</td>
	<td class="tablerow" colspan=3>
	<font color="#0000FF"><input name="article[status]" type="hidden" value="1" >你所在的会员组，发布信息后需要管理员审核！</font>
	</td>
</tr>
<?php
}
else
{
	echo "<input name='article[status]' type='hidden' value='3' >";
}
?>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" >
  <tr>
    <td width="40%">
	</td>
    <td height="25">
	<input type="hidden" name="article[companyid]" value="<?=$companyid?>" />
	<input type="submit" name="dosubmit" value=" 发  布 " />
	</td>
  </tr>
</table>
</form>
</body>
</html>