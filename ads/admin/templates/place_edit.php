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
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>修改广告位</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&id=<?=$id?>" method="post" name="myform">
    <tr> 
      <td class="tablerow">广告位名称</td>
      <td class="tablerow"><INPUT TYPE="hidden" name="place[placeid]" value="<?=$place[placeid]?>">
       <input size=40 name="place[placename]" type="text" value="<?=$place[placename]?>">
     </td>
    </tr>
   <tr> 
	<td class="tablerow">广告位介绍</td>
	<td class="tablerow">
	<input size=60 name="place[introduce]" type=text value="<?=$place[introduce]?>">
	</td>
	</tr>
   <tr>
	<TD class="tablerow">所在位置</TD>
	<TD class="tablerow">
<select name="place[channelid]">
<option value="0">网站首页</option>
<?php
foreach($_CHANNEL as $key=>$val)
{
    echo "<option value=$key ".($place[channelid]==$key ? "selected" : "" ).">$val[channelname]</option>";
}
?>
</select>
</td>
</tr>  
	<tr> 
	<td class="tablerow">广告价格</td>
	<td class="tablerow">
	<input size=6 name="place[price]" type="text" value="<?=$place[price]?>"> 元/月
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
      <td class="tablerow">宽：<input size=5 name="place[width]" type="text" value="<?=$place[width]?>"> px 高：<input size=5 name="place[height]" type="text" value="<?=$place[height]?>"> px</td>
    </tr>
     <tr>
         <td class="tablerow">是否启用</td>
         <td class="tablerow"><input type='radio' name='place[passed]' value='1' <?=($place[passed])?"checked":""?>> 是 <input type='radio' name='place[passed]' value='0' <?=($place[passed])?"":"checked"?>> 否</td>
     </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> <input type="submit" name="submit" value=" 修改 "> 
        &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>