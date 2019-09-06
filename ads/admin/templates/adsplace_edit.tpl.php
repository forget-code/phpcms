<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>编辑广告位</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&id=<?=$id?>" method="post" name="myform">
    <tr> 
      <td class="tablerow">广告位名称</td>
      <td class="tablerow">
<input size=40 name="place[placename]" type="text" value="<?php echo $place['placename']; ?>">
</td>
    </tr>
   <tr> 
	<td class="tablerow">广告位介绍</td>
	<td class="tablerow">
	<input size=60 name="place[introduce]" type="text" value="<?php echo $place['introduce']; ?>">
	</td>
	</tr>
   <tr>
	<TD class="tablerow">所在频道</TD>
	<TD class="tablerow">
<select name="place[channelid]">
<option value="0">全站</option>
<?php
foreach($CHANNEL as $key=>$val)
{
  if ($val['islink']==0) 
  {
    echo "<option value={$key}>{$val['channelname']}</option>";
  }
}
?>
</select>
</td>
</tr>  
	<tr> 
	<td class="tablerow">广告价格</td>
	<td class="tablerow">
	<input size=6 name="place[price]" type="text" value="<?php echo $place['price']; ?>"> 元/月
	</td>
	</tr>
	<tr> 
      <td class="tablerow">广告位模板</td>
      <td class="tablerow">
	 <?=$template_select?>
    </td>
    </tr>
    <tr> 
      <td class="tablerow">广告位尺寸</td>
      <td class="tablerow">宽：<input size=5 name="place[width]" type="text" value="<?php echo $place['width']; ?>"> px 高：<input size=5 name="place[height]" type="text" value="<?php echo $place['height']; ?>"> px</td>
    </tr>
     <tr>
         <td class="tablerow">是否启用</td>
         <td class="tablerow"><input type='radio' name='place[passed]' value='1' checked> 是 <input type='radio' name='place[passed]' value='0'> 否</td>
     </tr>
    <tr> 
      <td class="tablerow"><INPUT TYPE="hidden" name="placeid" value="<?php echo $place['placeid']; ?>"></td>
      <td class="tablerow"> <input type="submit" name="submit" value=" 添加 "> 
        &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>