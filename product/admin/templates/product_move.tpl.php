<?php include admintpl('header');?>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">商品首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=move">批量移动商品</a> &gt;&gt;</td>
	</td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=3>批量移动商品</th>
  </tr>
<form method="post" name="myform" action="?mod=product&file=product&action=move&dosubmit=1">
<input type="hidden" name="referer" value="<?=$referer?>">
<tr>
<td class="tablerow">
<input type="radio" name="movetype" value="1" <? if($productids){?>checked<?}?>>指定商品ID：<input type="text" name="productids" value="<?=$productids?>" size="40" onclick="this.form.movetype[0].checked=true"><br/>
<input type="radio" name="movetype" value="2" <? if(!$productids){?>checked<?}?>>指定栏目的商品<br/>
<select name="batchcatid[]" size="2" multiple style="height:360px;width:350px;" onclick="this.form.movetype[1].checked=true;">
<option style="background:#F1F3F5;color:green;">源 栏 目</option>
<?=$category_select?>
</td>
<td align="center" class="tablerow" width="60"> &gt;&gt;</td>
<td class="tablerow"><font color="red">Tips:</font>源栏目可按Ctrl键多选,目标栏目只能单选。<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如果指定文章ID，则不必选择源栏目。<br/>
<select name="targetcatid" size="2" style="height:360px;width:350px;">
<option style="background:#F1F3F5;color:blue;">目 标 栏 目</option>
<?=$category_select?>
</td>
</tr>
</tbody>
<tr align="center">
<td class="tablerow"></td>
<td class="tablerow"><input type="submit" value=" 移 动 "></td>
<td class="tablerow"></td>
</tr>
</form>
</table>
</body>
</html>