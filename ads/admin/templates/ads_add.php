<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>添加广告</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&id=<?=$id?>&channelid=<?=$channelid?>" method="post" name="myform">
    <tr> 
      <td class="tablerow">请选择广告位</td>
      <td class="tablerow">
<select name='ads[placeid]'>
<?php 
if(is_array($_adsplaces)){
	foreach($_adsplaces as $adsplace){
?>
<option value='<?=$adsplace[placeid]?>'><?=$_CHANNEL[$adsplace[channelid]][channelname]?>-<?=$adsplace[placename]?></option>
<?php 
	}
}
?>
</select> <font color="red">*</font>
</td>
    </tr>
	    <tr> 
      <td class="tablerow">广告名称</td>
      <td class="tablerow">
      <input size=40 name="ads[adsname]" type="text"> <font color="red">*</font>
     </td>
    </tr>
	<tr> 
	<td class="tablerow">广告介绍</td>
	<td class="tablerow">
	<input size=60 name="ads[introduce]" type=text>
	</td>
	</tr>
	<tr> 
	<td class="tablerow">广告类型</td>
	<td class="tablerow">
	<input type='radio' name='ads[type]' value='image' onclick="document.all.imageid.style.display='block';document.all.flashid.style.display='none';document.all.textid.style.display='none';document.all.codeid.style.display='none';" checked> 图片 
	<input type='radio' name='ads[type]' value='flash' onclick="document.all.imageid.style.display='none';document.all.flashid.style.display='';document.all.textid.style.display='none';document.all.codeid.style.display='none';"> FLASH 
	<input type='radio' name='ads[type]' value='text' onclick="document.all.imageid.style.display='none';document.all.flashid.style.display='none';document.all.textid.style.display='';document.all.codeid.style.display='none';"> 文本 
	<input type='radio' name='ads[type]' value='code' onclick="document.all.imageid.style.display='none';document.all.flashid.style.display='none';document.all.textid.style.display='none';document.all.codeid.style.display='';"> 代码 
	<font color="red">*</font>
	</td>
	</tr>
	<tr> 
	<td class="tablerow">广告内容</td>
	<td class="tablerow">
	<div id="imageid" style="display:block">图片地址：<input type="text" name="imageurl" size="50">&nbsp;<input type="button" name="upload" onclick="window.open('?mod=<?=$mod?>&file=upload&url=imageurl&extid=1','viewads','height=200,width=400,status=yes,toolbar=no,menubar=no,location=no,resizable=yes');" value=" 上传文件 " target="_blank"><font color="red">*</font><br/>图片提示：<input type="text" name="ads[alt]" size="50"><br/>链接地址：<input name="ads[linkurl]" type="text" size="50" value="http://"> <font color="red">*</font></div>
	<div id="flashid" style="display:none">FLASH地址：<input type="text" name="flashurl" size="50">&nbsp;<input type="button" name="upload" onclick="window.open('?mod=<?=$mod?>&file=upload&url=flashurl&extid=2','viewads','height=200,width=400,status=yes,toolbar=no,menubar=no,location=no,resizable=yes');" value=" 上传文件 " target="_blank"><font color="red">*</font><br/>背景透明：<input type='radio' name='ads[wmode]' value='transparent' checked> 是 <input type='radio' name='ads[wmode]' value=''> 否</div>
	<div id="textid"  style="display:none"><textarea name='ads[text]' cols='64' rows='15' id='text'></textarea> <font color="red">*</font></div>
	<div id="codeid"  style="display:none"><textarea name='ads[code]' cols='64' rows='15' id='code'></textarea> <font color="red">*</font></div>
	</td>
	</tr>
		<tr> 
	<td class="tablerow">客户帐号</td>
	<td class="tablerow">
	<input size=20 name="ads[username]" id="username" type=text>&nbsp;<input type="button" name="submit" value=" 检查用户名 " onclick="javascript:openwinx('?mod=member&file=member&action=user_exists&username='+myform.username.value,'user_exists','450','160')">
	</td>
	</tr>
		<tr> 
	<td class="tablerow">广告发布日期</td>
	<td class="tablerow">
	<script language=javascript>
	var dateFrom=new MyCalendar("ads[fromdate]","<?=date("Y-n-j")?>","选择,年,月,日,上一年,下一年,上个月,下个月,一,二,三,四,五,六"); dateFrom.display();</script> <font color="red">*</font>
	</td>
	</tr>
		<tr> 
	<td class="tablerow">广告结束日期</td>
	<td class="tablerow">
  <script language=javascript>
	var dateFrom=new MyCalendar("ads[todate]","<?= $lastmonth?>","选择,年,月,日,上一年,下一年,上个月,下个月,一,二,三,四,五,六"); dateFrom.display();</script>
	</td>
	</tr>
     <tr>
         <td class="tablerow">是否通过</td>
         <td class="tablerow"><input type='radio' name='ads[passed]' value='1' checked> 是 <input type='radio' name='ads[passed]' value='0'> 否</td>
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