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
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>作者添加</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&id=<?=$id?>&channelid=<?=$channelid?>" method="post" name="myform">
    <tr> 
      <td class="tablerow">作者名称</td>
      <td class="tablerow">
<input size=50 name="name" type=text value="<?=$author['name']?>">
</td>
    </tr>
	    <tr> 
      <td class="tablerow">所属栏目</td>
      <td class="tablerow">
	  <select name='catid'>
	  <option value='0'>本频道作者</option>
	  <?=$cat_option?>
	  </select>
</td>
    </tr>
<?if($action=='edit') { ?>
	<tr> 
	<td class="tablerow">文章总数</td>
	<td class="tablerow">
	<input size=50 name="articlenum" type=text value="<?=$author['articlenum']?>">
	</td>
	</tr>
<? } ?>

	<tr> 
      <td class="tablerow">作者图片</td>
      <td class="tablerow">
	  <input size=50 name="face" type=text value="<?=$author['face']?>"> <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=phpcms&file=uppic&channelid=<?=$channelid?>&uploadtext=face&action=thumb&width=150&height=150','upload','350','350')">
    </td>
    </tr>
    <tr> 
      <td class="tablerow">作者简介</td>
      <td class="tablerow"><textarea name='introduction' cols='60' rows='5'><?=$author['introduction']?></textarea></td>
    </tr>
     <tr>
         <td class="tablerow">推荐</td>
         <td class="tablerow"><input type='radio' name='elite' value='1' <?if($author['elite']) {?>checked<?}?>> 是 <input type='radio' name='elite' value='0' <?if(!$author['elite']) {?>checked<?}?>> 否</td>
   </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> <input type="submit" name="submit" value=" 确定 "> 
        &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>