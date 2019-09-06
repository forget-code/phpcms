<?php 
defined('IN_PHPCMS') or exit('Access Denied');
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
<form name="myframe_form" action="<?=$SITEURL?>/segment_word.php" method="get" target="myframe">
<input type="hidden" name="string" />
<input type="hidden" name="action" value="get_keywords" />
<input type="hidden" name="charset" value="gbk" />
</form>
<form action="" method="post" name="myform" >
<BR>
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=3>编辑产品</th>
 <tr> 
      <td width="19%" class="tablerow">所属栏目</td>
      <td class="tablerow"><font color="#FF0000"><?=$category_select?></font> </td>
    </tr>
<tr> 
	<td class="tablerow">标题</td>
	<td class="tablerow"><input name="product[title]" type="text" id="title" size="44" maxlength="100" class="inputtitle" onBlur="segment_word(this);" value="<?=$title?>"> <font color="#FF0000">*</font> <?=$style_edit?> 
	</td>
</tr>
<tr> 
	<td class="tablerow">产品型号</td>
	<td class="tablerow"><input name="product[model]" type="text" id="model" size="40" maxlength="100" value="<?=$model?>">
	</td>
</tr>
<tr>

      <td class="tablerow">关键字</td>
      <td class="tablerow"><input name="product[keywords]" type="text" id="keywords" size="40" title="提示;多个关键字请用半角逗号“,”隔开" value="<?=$keywords?>">
</td>
</tr>
<tr>

      <td class="tablerow">产品价格</td>
      <td class="tablerow"><input name="product[price]" type="text" id="price" size="10" value="<?=$price?>"> 元/ <input name="product[quantifier]" type="text" id="quantifier" size="5" value="<?=$quantifier?>"> <select name='selectquantifier' onclick="javascript:myform.quantifier.value=this.value">
<option value='' selected>选择</option>
<option value='台' >台</option>
<option value='个' >个</option>
<option value='张' >张</option>
<option value='只' >只</option>
<option value='把' >把</option>
<option value='件' >件</option>
<option value='次' >次</option>
<option value='吨' >吨</option>
<option value='公斤' >公斤</option>
</select>
</td>
</tr>
<tr> 
	<td class="tablerow">产品图片</td>
	<td class="tablerow" title="如果设置产品图片，则可以在首页以及栏目页以图片方式链接到产品"><input name="product[thumb]" type="text" id="thumb" size="53" value="<?=$thumb?>">  <input type="button" value="上传图片" onclick="javascript:openwinx('<?=PHPCMS_PATH?>upload.php?keyid=yp&uploadtext=thumb&type=thumb&width=150&height=150','upload','350','350')">
	</td>
</tr>
<tr> 
<td class="tablerow">详细说明</td>
<td valign="top" class="tablerow">
<textarea name="product[introduce]" id="introduce" cols="100" rows="25"><?=$introduce?></textarea> <?=editor("introduce", 'phpcms','100%','400')?>
</td>
</tr>
<?=$fields?>
<tr> 
	<td class="tablerow">产品状态</td>
	<td class="tablerow">

	<input name="product[status]" type="radio" value="3" <?php if($_groupid<4){?>checked<?php }else{ ?>disabled<?php } ?>> 已通过&nbsp;
	<input name="product[status]" type="radio" value="1" <?php if($_groupid==4){?>checked<?php } ?>> 待审核&nbsp;
	</td>
</tr>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" >
  <tr>
    <td width="40%" >
	</td>
    <td height="25">
	<input type="hidden" name="product[companyid]" value="<?=$companyid?>" />
	<input type="hidden" name="labelfile" value="<?=$labelfile?>" />
	<input type="hidden" name="forward" value="<?=$forward?>" />
	<input type="submit" name="dosubmit" value=" 确认修改 " />
	</td>
  </tr>
</table>
</form>
</body>
</html>