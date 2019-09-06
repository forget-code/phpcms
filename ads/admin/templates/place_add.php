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
    <th colspan=2>添加广告位</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&id=<?=$id?>" method="post" name="myform">
    <tr> 
      <td class="tablerow">广告位名称</td>
      <td class="tablerow">
<input size=40 name="place[placename]" type="text">
</td>
    </tr>
   <tr> 
	<td class="tablerow">广告位介绍</td>
	<td class="tablerow">
	<input size=60 name="place[introduce]" type=text>
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
    echo "<option value=$key>$val[channelname]</option>";
}
?>
</select>
</td>
</tr>  
	<tr> 
	<td class="tablerow">广告价格</td>
	<td class="tablerow">
	<input size=6 name="place[price]" type="text" value=0> 元/月
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
      <td class="tablerow">宽：<input size=5 name="place[width]" type="text" value="100"> px 高：<input size=5 name="place[height]" type="text" value="100"> px</td>
    </tr>
     <tr>
         <td class="tablerow">是否启用</td>
         <td class="tablerow"><input type='radio' name='place[passed]' value='1' checked> 是 <input type='radio' name='place[passed]' value='0'> 否</td>
     </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> <input type="submit" name="submit" value=" 添加 "> 
        &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>